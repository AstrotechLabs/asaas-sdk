<?php

declare(strict_types=1);

namespace AstrotechLabs\AsaasSdk;

class AssasGatewayParams
{
    public function __construct(
        public readonly string $apiKey,
        public readonly bool $isSandBox = true
    ) {
    }
}
