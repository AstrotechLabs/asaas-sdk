<?php

declare(strict_types=1);

error_reporting(E_ALL & ~E_DEPRECATED);

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

DG\BypassFinals::enable();
