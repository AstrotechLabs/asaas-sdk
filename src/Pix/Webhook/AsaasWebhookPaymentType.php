<?php

declare(strict_types=1);

namespace AstrotechLabs\AsaasSdk\Pix\Webhook;

enum AsaasWebhookPaymentType: string
{
    case CREDIT_CARD = 'CREDIT_CARD';
    case BOLETO = 'BOLETO';
    case DEBIT_CARD = 'DEBIT_CARD';
    case UNDEFINED = 'UNDEFINED';
    case TRANSFER = 'TRANSFER';
    case DEPOSIT = 'DEPOSIT';
    case PIX = 'PIX';
}
