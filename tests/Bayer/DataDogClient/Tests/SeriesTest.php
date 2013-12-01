<?php

namespace Bayer\DataDogClient\Tests;

use Bayer\DataDogClient\Series;
use Bayer\DataDogClient\Series\Metric;
use Bayer\DataDogClient\Series\Metric\Point;

class SeriesTest extends \PHPUnit_Framework_TestCase {

    public function testAddMetrics() {
        // Some test metrics
        $metric1 = new Metric('test1.metric.name', new Point(20));
        $metric2 = new Metric('test2.metric.name', new Point(30));
        $metric3 = new Metric('test3.metric.name', new Point(40));

        // Add metric by method
        $series1 = new Series();
        $this->assertEmpty($series1->getMetrics());
        $this->assertCount(0, $series1->getMetrics());
        $series1->addMetric($metric1);
        $this->assertCount(1, $series1->getMetrics());
        $this->assertEquals($metric1, $series1->getMetrics()[0]);

        // Add multiple metrics
        $series2 = new Series();
        $series2->addMetrics(array(
            $metric1,
            $metric2,
            $metric3
        ));
        $this->assertCount(3, $series2->getMetrics());
        $this->assertEquals($metric1, $series2->getMetrics()[0]);

        // Set metrics
        $series3 = new Series();
        $series3->addMetrics(array($metric1, $metric2, $metric3));
        $this->assertCount(3, $series3->getMetrics());
        $series3->setMetrics(array($metric1));
        $this->assertCount(1, $series3->getMetrics());
        $this->assertEquals($metric1, $series3->getMetrics()[0]);

        // Add metric by constructor
        $series4 = new Series(array(
            $metric1,
            $metric2,
            $metric3
        ));
        $this->assertCount(3, $series4->getMetrics());
    }

    public function testGetMetricByName() {
        $series = new Series();
        $metric = new Metric('test.metric.name', new Point(20));

        $series->addMetric($metric);
        $this->assertEquals($metric, $series->getMetric('test.metric.name'));
    }

    /**
     * @expectedException MetricNotFoundException
     */
    public function testGetNonExistingMetricThrowsException() {
        $series = new Series();
        $series->getMetric('non.existing.metric');
    }

    public function testRemoveMetricByName() {
        $series = new Series();
        $metric = new Metric('test.metric.name', new Point(20));

        $series->addMetric($metric);
        $this->assertCount(1, $series->getMetrics());
        $series->removeMetric('test.metric.name');
        $this->assertCount(0, $series->getMetrics());
    }

    /**
     * @expectedException MetricNotFoundException
     */
    public function testRemoveNonExistingMetricThrowsException() {
        $series = new Series();
        $series->removeMetric('non.existing.metric');
    }

    public function testRemoveAllMetricsDoesNotThrowException() {
        $series = new Series();
        $this->assertEmpty($series->getMetrics());
        $series->removeMetrics();
        $this->assertEmpty($series->getMetrics());
    }

    public function testRemoveMetrics() {
        $series = new Series();
        $metric = new Metric('test.metric.name', new Point(20));

        $series->addMetric($metric);
        $this->assertCount(1, $series->getMetrics());
        $series->removeMetrics();
        $this->assertCount(0, $series->getMetrics());
    }
}