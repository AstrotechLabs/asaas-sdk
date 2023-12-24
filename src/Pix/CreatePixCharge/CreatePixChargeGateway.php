<?php

declare(strict_types=1);

namespace AstrotechLabs\AsaasSdk\Pix\CreatePixCharge;

use AstrotechLabs\AsaasSdk\Pix\CreatePixCharge\Dto\CreatePixChargeOutput;
use AstrotechLabs\AsaasSdk\Pix\CreatePixCharge\Dto\PixData;
use AstrotechLabs\AsaasSdk\Pix\CreatePixCharge\Dto\QrCodeOutput;
use AstrotechLabs\AsaasSdk\Pix\CreatePixCharge\Exceptions\CreatePixChargeException;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException;

final class CreatePixChargeGateway
{
    private GuzzleClient $httpClient;
    private string $baseUrl;

    public function __construct(
        private readonly string $apiKey,
        private readonly bool $isSandBox = false
    ) {
        $this->baseUrl = $this->isSandBox ?
            'https://sandbox.asaas.com/api/v3/' :
            'https://www.asaas.com/api/v3/';

        $this->httpClient = new GuzzleClient([
            'base_uri' => $this->baseUrl,
            'timeout' => 10
        ]);
    }

    public function createCharge(PixData $pixData): CreatePixChargeOutput
    {
        $headers = [
            "Content-Type" => "application/json",
            "access_token" => $this->apiKey
        ];

        try {
            $response = $this->httpClient->post("payments", [
                'headers' => $headers,
                'json' => $pixData->values()
            ]);
        } catch (ClientException $e) {
            $responsePayload = json_decode($e->getResponse()->getBody()->getContents(), true);
            throw new CreatePixChargeException(
                1001,
                $responsePayload['errors'][0]['description'],
                $responsePayload['errors'][0]['code'],
                $pixData->values(),
                $responsePayload
            );
        }

        $responsePayload = json_decode($response->getBody()->getContents(), true);

        $qrCode = $this->getPaymentQrCode($responsePayload['id']);

        return new CreatePixChargeOutput(
            gatewayId: $responsePayload['id'],
            paymentUrl: $responsePayload['invoiceUrl'],
            copyPasteUrl: $qrCode->copyAndPaste,
            details: $responsePayload,
            qrCode: 'data:image/png;base64, ' . $qrCode->encodedImage
        );
    }

    public function getPaymentQrCode(string $paymentId): QrCodeOutput
    {
        $headers = [
            "Content-Type" => "application/json",
            "access_token" => $this->apiKey
        ];

        try {
            $response = $this->httpClient->get("payments/{$paymentId}/pixQrCode", ['headers' => $headers]);
        } catch (ClientException $e) {
            throw new CreatePixChargeException(
                $e->getCode(),
                $e->getMessage(),
                $this->isSandBox ? $e->getTraceAsString() : '',
                [],
                []
            );
        }

        $responsePayload = json_decode($response->getBody()->getContents(), true);

        return new QrCodeOutput(
            encodedImage: $responsePayload['encodedImage'],
            copyAndPaste: $responsePayload['payload'],
            expirationDate: $responsePayload['expirationDate']
        );
    }

    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }
}
