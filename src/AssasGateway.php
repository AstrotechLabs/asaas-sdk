<?php

namespace Astrotech\AsaasGateway;

use Astrotech\AsaasGateway\CreateAsaasPixChargeGateway\CreateAsaasPixChargeGateway;
use Astrotech\AsaasGateway\CreateAsaasPixChargeGateway\Dto\PixData;

class AssasGateway
{
    public function __construct(
        private readonly AssasGatewayParams $params
    ) {
    }

    public function createCharge(PixData $pixData): array
    {
        $createPixChargeGateway = new CreateAsaasPixChargeGateway(
            apiKey: $this->params->apiKey,
            isSandBox: $this->params->isSandBox
        );

        return $createPixChargeGateway->createCharge($pixData)->toArray();
    }
}
