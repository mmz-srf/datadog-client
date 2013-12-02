<?php

namespace Bayer\DataDogClient\Tests;

use Bayer\DataDogClient\Factory;
use Bayer\DataDogClient\Event;
use Bayer\DataDogClient\Series\Metric;

class FactoryTest extends \PHPUnit_Framework_TestCase {
    public function testFactoryCanCreateMetric() {
        $metric = Factory::buildMetric(
            'test.metric.name',
            array(
                array(20),
                array(time() - 20, 20),
            ),
            array(
                'type' => Metric::TYPE_COUNTER,
                'host' => 'foo.bar.com',
                'tags' => array('foo' => 'bar')
            )
        );

        $this->assertEquals(Metric::TYPE_COUNTER, $metric->getType());
        $this->assertEquals('foo.bar.com', $metric->getHost());
        $this->assertEquals(array('foo' => 'bar'), $metric->getTags());

        $this->assertInstanceOf('Bayer\DataDogClient\Series\Metric', $metric);
    }

    public function testFactoryCanCreateEvent() {
        $event = Factory::buildEvent(
            'This is a dummy event',
            'My Event',
            array(
                'timestamp'      => 123456,
                'priority'       => Event::PRIORITY_LOW,
                'type'           => Event::TYPE_SUCCESS,
                'sourceType'     => Event::SOURCE_BITBUCKET,
                'aggregationKey' => 'foo.bar',
                'tags'           => array('foo' => 'bar')
            )
        );

        $this->assertEquals(123456, $event->getTimestamp());
        $this->assertEquals(Event::PRIORITY_LOW, $event->getPriority());
        $this->assertEquals(Event::TYPE_SUCCESS, $event->getType());
        $this->assertEquals(Event::SOURCE_BITBUCKET, $event->getSourceType());
        $this->assertEquals('foo.bar', $event->getAggregationKey());
        $this->assertEquals(array('foo' => 'bar'), $event->getTags());

        $this->assertInstanceOf('Bayer\DataDogClient\Event', $event);
    }

    /**
     * @expectedException \Bayer\DataDogClient\Factory\InvalidPropertyException
     */
    public function testInvalidOptionThrowsException() {
        Factory::buildEvent(
            'Dummy event',
            'My Event',
            array(
                'foo' => 'bar'
            )
        );
    }
}