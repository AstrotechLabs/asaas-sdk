<?php

declare(strict_types=1);

namespace AstrotechLabs\AsaasSdk\Transfer\CreateTransferCharge\Dto;

use JsonSerializable;

final class CreateTransferChargeOutput implements JsonSerializable
{
    public function __construct(
        public readonly string $gatewayId,
        public readonly string $status,
        public readonly float $fee,
        public readonly float $value,
        public readonly bool $authorized,
        public readonly array $details,
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
