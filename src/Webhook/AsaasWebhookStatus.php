<?php

declare(strict_types=1);

namespace AstrotechLabs\AsaasSdk\Webhook;

enum AsaasWebhookStatus: string
{
    case RECEIVED = "RECEIVED";
    case OVERDUE = "OVERDUE";
}
