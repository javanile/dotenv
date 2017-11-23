<?php

namespace Javanile\Dotenv\Tests;

use Javanile\Producer;
use PHPUnit\Framework\TestCase;
use Javanile\Dotenv\Dotenv;

Producer::addPsr4([
    'Javanile\Dotenv\\' => __DIR__.'/../src',
    'Javanile\Dotenv\\Tests\\' => __DIR__,
]);

final class DotenvTest extends TestCase
{
    public function testCreateAnInstance()
    {
        $object = new Dotenv();
        $this->assertInstanceOf('Javanile\Dotenv\Dotenv', $object);

        $output = "Hello World!";
        $this->assertRegexp('/World/i', $output);
    }
}
