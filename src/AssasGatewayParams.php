<?php

namespace Astrotech\AsaasGateway;

class AssasGatewayParams
{
    public function __construct(
        public readonly string $apiKey,
        public readonly bool $isSandBox = true
    ) {
    }
}
