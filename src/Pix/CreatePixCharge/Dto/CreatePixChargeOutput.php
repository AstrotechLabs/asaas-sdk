<?php

declare(strict_types=1);

namespace AstrotechLabs\AsaasSdk\Pix\CreatePixCharge\Dto;

use JsonSerializable;

final class CreatePixChargeOutput implements JsonSerializable
{
    public function __construct(
        public readonly string $gatewayId,
        public readonly string $paymentUrl,
        public readonly string $copyPasteUrl,
        public readonly array $details,
        public readonly string $qrCode
    ) {
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
