<?php

namespace Bayer\DataDogClient\Tests;

use Bayer\DataDogClient\Client;

class ClientTest extends \PHPUnit_Framework_TestCase {
    public function testConstructor() {
        $client = new Client('api_key');
        $this->assertInstanceOf('Bayer\DataDogClient\Client', $client);
    }
}