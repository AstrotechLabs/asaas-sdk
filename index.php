<?php

declare(strict_types=1);

use Astrotech\AsaasGateway\AssasGatewayParams;
use Astrotech\AsaasGateway\CreateAsaasPixChargeGateway\Dto\PixData;
use Astrotech\AsaasGateway\Enum\BillingTypes;

require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$asaasGateway = new \Astrotech\AsaasGateway\AssasGateway(new AssasGatewayParams(
    apiKey: $_ENV['ASAAS_API_KEY'],
    isSandBox: boolval($_ENV['ASAAS_SANDBOX'])
));

$data = $asaasGateway->createCharge(new PixData(
    customer: 'cus_000005797885',
    billingType: BillingTypes::PIX,
    value: 650.90,
    dueDate: "2023-12-20"
));

$a = 0;
