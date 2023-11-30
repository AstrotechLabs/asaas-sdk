<?php

declare(strict_types=1);

use Dotenv\Exception\ValidationException;
use Dotenv\Exception\InvalidPathException;

require __DIR__ . '/vendor/autoload.php';

try {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    $dotenv->required('COMPOSE_PROJECT_NAME')->notEmpty();
    $dotenv->required('APP_TIMEZONE')->notEmpty();
    $dotenv->required('APP_ENV')->notEmpty()->allowedValues(['dev', 'staging', 'production']);
    $dotenv->required('BANCO_BRASIL_PIX_KEY')->notEmpty();
    $dotenv->required('BANCO_BRASIL_DEV_APP_ID')->notEmpty();
    $dotenv->required('BANCO_BRASIL_CLIENT_ID')->notEmpty();
    $dotenv->required('BANCO_BRASIL_CLIENT_SECRET')->notEmpty();
    $dotenv->required('BANCO_BRASIL_SANDBOX')->notEmpty();

    echo '===================================================' . PHP_EOL;
    echo "System environment variables are ok!" . PHP_EOL;
    echo '===================================================' . PHP_EOL;
    exit(0);
} catch (ValidationException | InvalidPathException $e) {
    echo '===================================================' . PHP_EOL;
    echo "!!! ERROR ON VALIDATE ENV VARIABLES !!!" . PHP_EOL;
    echo '===================================================' . PHP_EOL;
    echo $e->getMessage() . PHP_EOL;
    exit(1);
}
