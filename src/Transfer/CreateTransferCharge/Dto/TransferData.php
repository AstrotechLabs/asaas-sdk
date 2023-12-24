<?php

namespace AstrotechLabs\AsaasSdk\Transfer\CreateTransferCharge\Dto;

use AstrotechLabs\AsaasSdk\Transfer\Enum\OperationTypes;
use AstrotechLabs\AsaasSdk\Transfer\Enum\PixKeyTypes;
use DateTimeImmutable;

class TransferData
{
    public function __construct(
        public readonly float $value,
        public readonly string $pixAddressKey,
        public readonly PixKeyTypes $pixAddressKeyType,
        public readonly OperationTypes $operationType = OperationTypes::PIX,
        public readonly ?DateTimeImmutable $scheduleDate = null,
        public readonly ?string $description = null,
    ) {
    }

    public function values(): array
    {
        $values = get_object_vars($this);
        array_walk($values, fn (&$value, $property) => $value = $this->get($property));
        return $values;
    }

    public function get(string $property): mixed
    {
        $getter = "get" . ucfirst($property);

        if (method_exists($this, $getter)) {
            return $this->{$getter}();
        }

        return $this->{$property};
    }

    public function getPixKeyType(): string
    {
        return $this->pixKeyType->value;
    }

    public function getOperationType(): string
    {
        return $this->operationType->value;
    }
}
