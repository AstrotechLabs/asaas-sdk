<?php

declare(strict_types=1);

namespace AstrotechLabs\AsaasSdk\Transfer\CreateTransferCharge;

use AstrotechLabs\AsaasSdk\Transfer\CreateTransferCharge\Dto\CreateTransferChargeOutput;
use AstrotechLabs\AsaasSdk\Transfer\CreateTransferCharge\Dto\TransferData;
use AstrotechLabs\AsaasSdk\Transfer\CreateTransferCharge\Exceptions\CreateTransferChargeException;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException;

final class CreateTransferChargeGateway
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

    public function createCharge(TransferData $transferData): CreateTransferChargeOutput
    {
        $headers = [
            "Content-Type" => "application/json",
            "access_token" => $this->apiKey
        ];

        try {
            $response = $this->httpClient->post("transfers", [
                'headers' => $headers,
                'json' => $transferData->values()
            ]);
        } catch (ClientException $e) {
            $responsePayload = json_decode($e->getResponse()->getBody()->getContents(), true);
            throw new CreateTransferChargeException(
                1001,
                $responsePayload['errors'][0]['description'],
                $responsePayload['errors'][0]['code'],
                $transferData->values(),
                $responsePayload
            );
        }

        $responsePayload = json_decode($response->getBody()->getContents(), true);

        return new CreateTransferChargeOutput(
            gatewayId: $responsePayload['id'],
            status: $responsePayload['status'],
            fee: $responsePayload['transferFee'],
            value: $responsePayload['value'],
            authorized: $responsePayload['authorized'],
            details: $responsePayload,
        );
    }

    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }
}
