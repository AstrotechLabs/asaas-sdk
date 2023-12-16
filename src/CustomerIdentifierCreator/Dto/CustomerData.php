<?php

declare(strict_types=1);

namespace AstrotechLabs\AsaasSdk\CustomerIdentifierCreator\Dto;

class CustomerData
{
    public function __construct(
        public readonly string $name,
        public readonly string $phone,
        public readonly string $cpfCnpj,
        public readonly ?string $email = null,
        public readonly ?string $postalCode = null,
        public readonly ?string $address = null,
        public readonly ?int $addressNumber = null,
        public readonly ?string $complement = null,
        public readonly ?string $province = null,
        public readonly ?string $externalReference = null,
        public readonly ?bool $notificationDisabled = null,
        public readonly ?string $additionalEmails = null,
        public readonly ?string $municipalInscription = null,
        public readonly ?string $stateInscription = null,
        public readonly ?string $observations = null,
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
}
