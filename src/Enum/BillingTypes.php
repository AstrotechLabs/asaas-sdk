<?php

namespace Astrotech\AsaasGateway\Enum;

enum BillingTypes: string
{
    case UNDEFINED = 'UNDEFINED';
    case BOLETO = 'BOLETO';
    case CREDIT_CARD = 'CREDIT_CARD';
    case PIX = 'PIX';
}
