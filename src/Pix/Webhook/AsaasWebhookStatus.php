<?php

declare(strict_types=1);

namespace AstrotechLabs\AsaasSdk\Pix\Webhook;

enum AsaasWebhookStatus: string
{
    case RECEIVED = "RECEIVED";
    case OVERDUE = "OVERDUE";
}
