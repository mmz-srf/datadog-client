<?php

namespace Bayer\DataDogClient\Tests;

use Bayer\DataDogClient\Client;
use Bayer\DataDogClient\Client\EmptySeriesException;
use Bayer\DataDogClient\Client\EmptyMetricException;

class ClientTest extends \PHPUnit_Framework_TestCase {

    const API_KEY = 'api_key';
    const APP_KEY = 'app_key';

    protected $client;

    protected function setUp() {
        $this->client = new Client(self::API_KEY, self::APP_KEY);
    }
    public function testConstructor() {
        $client = new Client(self::API_KEY);
        $this->assertInstanceOf('Bayer\DataDogClient\Client', $client);
    }

    public function testGetAndSetApiKey() {
        $this->assertEquals(self::API_KEY, $this->client->getApiKey());
        $this->client->setApiKey('test_api_key');
        $this->assertEquals('test_api_key', $this->client->getApiKey());
    }

    public function testGetAndSetApplicationKey() {
        $this->assertEquals(self::APP_KEY, $this->client->getApplicationKey());
        $this->client->setApplicationKey('test_app_key');
        $this->assertEquals('test_api_key', $this->client->getApplicationKey());
    }

    public function testSendSeries() {
        $series = new Series(new Metric(
            'test.metric.name',
            new Point(20)
        ));

        $this->client->sendSeries($series);
    }

    /**
     * @expectedException EmptySeriesException
     */
    public function testDoNotSendEmptySeries() {
        $series = new Series();

        $this->client->sendSeries($series);
    }
}