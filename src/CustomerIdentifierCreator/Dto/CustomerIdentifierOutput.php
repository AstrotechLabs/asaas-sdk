<?php

declare(strict_types=1);

namespace AstrotechLabs\AsaasSdk\CustomerIdentifierCreator\Dto;

class CustomerIdentifierOutput
{
    public function __construct(
        public readonly string $identifier
    ) {
    }
}
