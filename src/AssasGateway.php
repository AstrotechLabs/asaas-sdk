<?php

declare(strict_types=1);

namespace AstrotechLabs\AsaasSdk;

use AstrotechLabs\AsaasSdk\CreatePixCharge\Dto\PixData;
use AstrotechLabs\AsaasSdk\CreatePixCharge\CreatePixChargeGateway;

class AssasGateway
{
    public function __construct(
        private readonly AssasGatewayParams $params
    ) {
    }

    public function createCharge(PixData $pixData): array
    {
        $createPixChargeGateway = new CreatePixChargeGateway(
            apiKey: $this->params->apiKey,
            isSandBox: $this->params->isSandBox
        );

        return $createPixChargeGateway->createCharge($pixData)->toArray();
    }
}
