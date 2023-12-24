<?php

declare(strict_types=1);

namespace AstrotechLabs\AsaasSdk\Pix\CustomerIdentifierCreator\Dto;

class CustomerIdentifierOutput
{
    public function __construct(
        public readonly string $identifier
    ) {
    }
}
