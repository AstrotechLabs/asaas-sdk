<?php

declare(strict_types=1);

namespace AstrotechLabs\AsaasSdk;

use AstrotechLabs\AsaasSdk\Pix\CreatePixCharge\CreatePixChargeGateway;
use AstrotechLabs\AsaasSdk\Pix\CreatePixCharge\Dto\PixData;
use AstrotechLabs\AsaasSdk\Transfer\CreateTransferCharge\CreateTransferChargeGateway;
use AstrotechLabs\AsaasSdk\Transfer\CreateTransferCharge\Dto\TransferData;

class AssasGateway
{
    public function __construct(
        private readonly AssasGatewayParams $params
    ) {
    }

    public function createPixCharge(PixData $pixData): array
    {
        $createPixChargeGateway = new CreatePixChargeGateway(
            apiKey: $this->params->apiKey,
            isSandBox: $this->params->isSandBox
        );

        return $createPixChargeGateway->createCharge($pixData)->toArray();
    }

    public function createTransferCharge(TransferData $transferData): array
    {
        $createTransferChargeGateway = new CreateTransferChargeGateway(
            apiKey: $this->params->apiKey,
            isSandBox: $this->params->isSandBox
        );

        return $createTransferChargeGateway->createCharge($transferData)->toArray();
    }
}
