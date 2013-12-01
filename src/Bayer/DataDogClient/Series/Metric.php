<?php

namespace Bayer\DataDogClient\Series;

use Bayer\DataDogClient\Series\Metric\InvalidTypeException;
use Bayer\DataDogClient\Series\Metric\Point;

class Metric {

    const TYPE_GAUGE   = 'gauge';
    const TYPE_COUNTER = 'counter';

    protected $name;
    protected $type;
    protected $host;
    protected $tags = array();
    protected $points = array();

    /**
     * @param string        $name
     * @param Point|Point[] $points
     */
    public function __construct($name, $points) {
        $this->setName($name);
        if ($points instanceof Point) {
            $points = array($points);
        }
        $this->setPoints($points);
        $this->setType(self::TYPE_GAUGE);
    }

    /**
     * @return mixed
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param mixed $name
     *
     * @return Metric
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getType() {
        return $this->type;
    }

    /**
     * @param mixed $type
     * @throws InvalidTypeException
     *
     * @return Metric
     */
    public function setType($type) {
        if (!$this->isValidType($type)) {
            throw new InvalidTypeException('Type must be one of Metric::TYPE_*');
        }
        $this->type = $type;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getHost() {
        return $this->host;
    }

    /**
     * @param mixed $host
     *
     * @return Metric
     */
    public function setHost($host) {
        $this->host = $host;

        return $this;
    }

    /**
     * @return array
     */
    public function getTags() {
        return $this->tags;
    }

    /**
     * @param array $tags
     *
     * @return Metric
     */
    public function setTags($tags) {
        $this->tags = $tags;

        return $this;
    }

    /**
     * @param $name
     * @param $value
     *
     * @return Metric
     */
    public function addTag($name, $value) {
        $this->tags[$name] = $value;

        return $this;
    }

    /**
     * @param $name
     *
     * @return Metric
     */
    public function removeTag($name) {
        if (isset($this->tags[$name])) {
            unset($this->tags[$name]);
        }

        return $this;
    }

    /**
     * @return Metric
     */
    public function removeTags() {
        $this->tags = array();

        return $this;
    }

    /**
     * @return Point[]
     */
    public function getPoints() {
        return $this->points;
    }

    /**
     * @param Point[] $points
     *
     * @return Metric
     */
    public function setPoints(array $points) {
        $this->removePoints();
        $this->addPoints($points);

        return $this;
    }

    /**
     * @param Point $point
     *
     * @return Metric
     */
    public function addPoint(Point $point) {
        $this->points[] = $point;

        return $this;
    }

    /**
     * @param array $points
     *
     * @return Metric
     */
    public function addPoints(array $points) {
        foreach ($points as $point) {
            $this->addPoint($point);
        }

        return $this;
    }

    /**
     * @return Metric
     */
    public function removePoints() {
        $this->points = array();

        return $this;
    }

    /**
     * @return array
     */
    public function toArray() {
        $data = array(
            'metric' => $this->getName(),
            'type'   => $this->getType(),
            'points' => array(),
        );

        foreach ($this->getPoints() as $point) {
            $data['points'][] = $point->toArray();
        }

        if ($host = $this->getHost()) {
            $data['host'] = $host;
        }

        if ($tags = $this->getTags()) {
            $data['tags'] = array();
            foreach ($tags as $tag => $value) {
                $data['tags'][] = "$tag:$value";
            }
        }

        return $data;
    }


    /**
     * @param $type
     * @return bool
     */
    protected function isValidType($type) {
        return in_array(
            $type,
            array(
                self::TYPE_GAUGE,
                self::TYPE_COUNTER
            )
        );
    }
}