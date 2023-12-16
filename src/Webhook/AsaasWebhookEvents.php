<?php

declare(strict_types=1);

namespace AstrotechLabs\AsaasSdk\Webhook;

/**
 * @see https://docs.asaas.com/docs/webhook-para-cobrancas
 */
enum AsaasWebhookEvents: string
{
    case PAYMENT_CONFIRMED = "PAYMENT_CONFIRMED";
    case PAYMENT_RECEIVED = "PAYMENT_RECEIVED";
    case PAYMENT_REFUNDED = "PAYMENT_REFUNDED";
    case PAYMENT_DELETED = "PAYMENT_DELETED";
    case PAYMENT_OVERDUE = "PAYMENT_OVERDUE";
}
