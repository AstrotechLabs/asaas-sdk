<?php

declare(strict_types=1);

namespace AstrotechLabs\AsaasSdk\Pix\CreatePixCharge\Dto;

final class QrCodeOutput
{
    public function __construct(
        public readonly string $encodedImage,
        public readonly string $copyAndPaste,
        public readonly string $expirationDate
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
