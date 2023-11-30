<?php

declare(strict_types=1);

namespace Tests;

use DI\Container;
use Faker\Generator;
use Faker\Factory as Faker;
use PHPUnit\Framework\TestCase as PhpUnitTestCase;

abstract class TestCase extends PhpUnitTestCase
{
    use Asserts;

    protected static Generator $faker;
    protected static Container $container;
    private array $stubStorage = [];

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        self::$faker = Faker::create('pt_BR');
        // self::$container = require CONFIG_PATH . '/dic.php';
    }
}
