<?php

declare(strict_types=1);

namespace AstrotechLabs\AsaasSdk\Enum;

enum BillingTypes: string
{
    case UNDEFINED = 'UNDEFINED';
    case BOLETO = 'BOLETO';
    case CREDIT_CARD = 'CREDIT_CARD';
    case PIX = 'PIX';
}
