<?php

declare(strict_types=1);

namespace AstrotechLabs\AsaasSdk\Pix\CreatePixCharge\Dto;

use AstrotechLabs\AsaasSdk\Pix\CustomerIdentifierCreator\Dto\CustomerData;
use AstrotechLabs\AsaasSdk\Pix\Enum\BillingTypes;

final class PixData
{
    public function __construct(
        public readonly CustomerData $customer,
        public readonly BillingTypes $billingType,
        public readonly float $value,
        public readonly string $dueDate
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

    public function getBillingType(): string
    {
        return $this->billingType->value;
    }
}
