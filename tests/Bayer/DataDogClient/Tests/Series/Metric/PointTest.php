<?php

namespace Bayer\DataDogClient\Tests;

use Bayer\DataDogClient\Series\Metric;
use Bayer\DataDogClient\Series\Metric\Point;

class PointTest extends \PHPUnit_Framework_TestCase {

    public function testCreatePoint() {
        $point = new Point(20);
        $this->assertEquals(20, $point->getValue());
    }

    public function testChangePointValue() {
        $point = new Point(20);
        $point->setValue(30);
        $this->assertEquals(30, $point->getValue());
    }

    public function testPointHasDefaultTimestamp() {
        $point = new Point(20);
        $this->assertEquals(time(), $point->getTimestamp());
    }

    public function testSetPointTimestamp() {
        $point = new Point(20, 123456786);
        $this->assertEquals(123456786, $point->getTimestamp());

        $point->setTimestamp(22223333);
        $this->assertEquals(22223333, $point->getTimestamp());
    }

    /**
     * @expectedException \Bayer\DataDogClient\Series\Metric\Point\InvalidValueException
     */
    public function testAcceptOnlyNumericValues() {
        new Point('20');
    }

    /**
     * @expectedException \Bayer\DataDogClient\Series\Metric\Point\InvalidTimestampException
     */
    public function testInvalidTimestampThrowsException() {
        new Point(20, '12320013');
    }
}