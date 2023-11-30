<?php

namespace Astrotech\AsaasGateway\AsaasCustomerIdentifierCreator\Dto;

class AsaasCustomerIdentifierOutput
{
    public function __construct(
        public readonly string $identifier
    ) {
    }
}
