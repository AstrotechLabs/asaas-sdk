<?php

declare(strict_types=1);

namespace Astrotech\AsaasGateway\AsaasCustomerIdentifierCreator;

use Astrotech\AsaasGateway\AsaasCustomerIdentifierCreator\Dto\AsaasCustomerData;
use Astrotech\AsaasGateway\AsaasCustomerIdentifierCreator\Dto\AsaasCustomerIdentifierOutput;
use Astrotech\AsaasGateway\AsaasCustomerIdentifierCreator\Exceptions\CreateAsaasCustomerIdentifierException;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException;

class AsaasCustomerIdentifierCreator
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

    public function generateCustomerIdentifier(AsaasCustomerData $customerData): AsaasCustomerIdentifierOutput
    {
        $headers = [
            "Content-Type" => "application/json",
            "access_token" => $this->apiKey
        ];

        try {
            $response = $this->httpClient->post("customers", [
                'headers' => $headers,
                'json' => $customerData->values()
            ]);
        } catch (ClientException $e) {
            $responsePayload = json_decode($e->getResponse()->getBody()->getContents(), true);
            throw new CreateAsaasCustomerIdentifierException(
                1001,
                $responsePayload['errors'][0]['description'],
                $responsePayload['errors'][0]['code'],
                $customerData->values(),
                $responsePayload
            );
        }

        $responsePayload = json_decode($response->getBody()->getContents(), true);

        return new AsaasCustomerIdentifierOutput(identifier: $responsePayload['id']);
    }
}
