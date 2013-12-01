<?php

namespace Bayer\DataDogClient;

use Bayer\DataDogClient\Client\EmptySeriesException;

class Client {
    protected $apiKey;
    protected $applicationKey;

    public function __construct($apiKey, $applicationKey = null) {
        $this->apiKey         = $apiKey;
        $this->applicationKey = $applicationKey;
    }

    /**
     * @return string
     */
    public function getApiKey() {
        return $this->apiKey;
    }

    /**
     * @param string $apiKey
     *
     * @return Client
     */
    public function setApiKey($apiKey) {
        $this->apiKey = $apiKey;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getApplicationKey() {
        return $this->applicationKey;
    }

    /**
     * @param string $applicationKey
     *
     * @return Client
     */
    public function setApplicationKey($applicationKey) {
        $this->applicationKey = $applicationKey;

        return $this;
    }

    public function sendSeries(Series $series) {
        if (empty($series->getMetrics())) {
            throw new EmptySeriesException('The series must contain metric data to send');
        }

        return $this;
    }


}