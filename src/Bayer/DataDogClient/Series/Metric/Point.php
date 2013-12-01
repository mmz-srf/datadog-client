<?php

namespace Bayer\DataDogClient\Series\Metric;

use Bayer\DataDogClient\Series\Metric\Point\InvalidTimestampException;
use Bayer\DataDogClient\Series\Metric\Point\InvalidValueException;

class Point {
    protected $value;
    protected $timestamp;

    public function __construct($value, $timestamp = null) {
        $this->setValue($value);

        if (null === $timestamp) {
            $timestamp = time();
        }
        $this->setTimestamp($timestamp);
    }

    /**
     * @return mixed
     */
    public function getValue() {
        return $this->value;
    }

    /**
     * @param mixed $value
     *
     * @throws Point\InvalidValueException
     *
     * @return Point
     */
    public function setValue($value) {
        if (!is_integer($value) && !is_float($value)) {
            throw new InvalidValueException('Value must be numeric');
        }
        $this->value = $value;

        return $this;
    }

    /**
     * @return int
     */
    public function getTimestamp() {
        return $this->timestamp;
    }

    /**
     * @param int $timestamp
     *
     * @throws InvalidTimestampException
     *
     * @return Point
     */
    public function setTimestamp($timestamp) {
        if (!is_integer($timestamp)) {
            throw new InvalidTimestampException('Timestamp must be an integer');
        }
        $this->timestamp = $timestamp;

        return $this;
    }
}