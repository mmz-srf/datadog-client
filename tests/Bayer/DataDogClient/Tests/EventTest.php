<?php

namespace Bayer\DataDogClient\Tests;

use Bayer\DataDogClient\Event;

class EventTest extends \PHPUnit_Framework_TestCase {
    public function testGetAndSetTitleAndText() {
        $event = new Event('Title', 'Text');
        $this->assertEquals('Title', $event->getTitle());
        $this->assertEquals('Text', $event->getText());

        $event->setTitle('NewTitle');
        $this->assertEquals('NewTitle', $event->getTitle());

        $event->setText('NewText');
        $this->assertEquals('NewText', $event->getText());
    }

    public function testGetAndSetTimestamp() {
        $event = new Event('Title', 'Text');
        $this->assertEquals(time(), $event->getTimestamp());

        $event->setTimestamp(123456789);
        $this->assertEquals(123456789, $event->getTimestamp());
    }

    public function testGetAndSetPriority() {
        $event = new Event('Title', 'Text');
        $this->assertEquals(Event::PRIORITY_NORMAL, $event->getPriority());

        $event->setPriority(Event::PRIORITY_LOW);
        $this->assertEquals(Event::PRIORITY_LOW, $event->getPriority());
    }

    /**
     * @expectedException \Bayer\DataDogClient\Event\InvalidPriorityException
     */
    public function testInvalidPriorityThrowsException() {
        $event = new Event('Title', 'Text');
        $event->setPriority('foo');
    }

    public function testGetAndSetTags() {
        $event = new Event('Title', 'Text');
        $this->assertEmpty($event->getTags());
        $this->assertEquals(array(), $event->getTags());

        $event->addTag('foo', 'bar');
        $this->assertCount(1, $event->getTags());

        $event->removeTag('foo');
        $this->assertCount(0, $event->getTags());

        $event2 = new Event('Title', 'Text');
        $this->assertCount(0, $event2->getTags());
        $event2->setTags(
            array(
                array('foo', 'bar'),
                array('bar', 'baz')
            )
        );
        $this->assertCount(2, $event2->getTags());
        $event2->removeTags();
    }

    public function testRemoveNonExistingTag() {
        $event = new Event('Title', 'Text');
        $event->removeTag('foo');
    }

    public function testGetAndSetAlertType() {
        $event = new Event('Title', 'Text');

        $this->assertEquals(Event::TYPE_INFO, $event->getType());

        $event->setType(Event::TYPE_ERROR);
        $this->assertEquals(Event::TYPE_ERROR, $event->getType());
    }

    /**
     * @expectedException \Bayer\DataDogClient\Event\InvalidTypeException
     */
    public function testInvalidTypeThrowsException() {
        $event = new Event('Title', 'Text');
        $event->setType('foo');
    }

    public function testGetAndSetAggregationKey() {
        $event = new Event('Title', 'Text');
        $this->assertNull($event->getAggregationKey());

        $event->setAggregationKey('test');
        $this->assertEquals('test', $event->getAggregationKey());
    }

    public function testGetAndSetSourceType() {
        $event = new Event('Title', 'Text');
        $this->assertNull($event->getSourceType());

        $event->setSourceType(Event::SOURCE_NAGIOS);
        $this->assertEquals(Event::SOURCE_NAGIOS, $event->getSourceType());
    }

    /**
     * @expectedException \Bayer\DataDogClient\Event\InvalidSourceTypeException
     */
    public function testInvalidSourceTypeThrowsException() {
        $event = new Event('Title', 'Text');
        $event->setSourceType('foo');
    }
}