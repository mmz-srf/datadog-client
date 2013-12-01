<?php

namespace Bayer\DataDogClient\Tests;

use Bayer\DataDogClient\Client;
use Bayer\DataDogClient\Event;
use Bayer\DataDogClient\Series;
use Bayer\DataDogClient\Series\Metric;
use Bayer\DataDogClient\Series\Metric\Point;

class ClientTest extends \PHPUnit_Framework_TestCase {

    const API_KEY = '';
    const APP_KEY = '';

    /**
     * @var Client
     */
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
        $this->assertEquals('test_app_key', $this->client->getApplicationKey());
    }

    public function testSendSeries() {
        $series = new Series();
        $metric1 = new Metric('test.metric.name', array(
            new Point(20, time()),
            new Point(15, time() - 5),
            new Point(10, time() - 10),
        ));
        $metric1->setType(Metric::TYPE_GAUGE)
            ->setHost('host1.com')
            ->addTag('test', 'tag');

        $series->addMetric($metric1);

        $metric2 = new Metric('test.metric2.name', array(
            new Point(18, time()),
            new Point(21, time() - 1),
            new Point(12, time() - 2),
        ));
        $metric2->setType(Metric::TYPE_COUNTER);

        $series->addMetric($metric2);

        $this->client->sendSeries($series);
    }

    public function testSendEvent() {
        $event = new Event('TestEvent', 'This is a testevent');
        $event->addTag('foo', 'bar')
            ->setType(Event::TYPE_SUCCESS)
            ->setSourceType(Event::SOURCE_MYAPPS)
            ->setAggregationKey('unittest')
            ->setPriority(Event::PRIORITY_LOW);

        $this->client->sendEvent($event);

    }

    /**
     * @expectedException \Bayer\DataDogClient\Client\EmptySeriesException
     */
    public function testDoNotSendEmptySeries() {
        $series = new Series();

        $this->client->sendSeries($series);
    }
}