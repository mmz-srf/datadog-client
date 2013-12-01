<?php

namespace Bayer\DataDogClient;

use Bayer\DataDogClient\Client\EmptySeriesException;
use Bayer\DataDogClient\Series\Metric;
use Bayer\DataDogClient\Series\Metric\Point;

class Client {

    const ENDPOINT_EVENT  = 'https://app.datadoghq.com/api/v1/events?api_key=';
    const ENDPOINT_SERIES = 'https://app.datadoghq.com/api/v1/series?api_key=';

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

    /**
     * @param Series $series
     * @return Client
     * @throws Client\EmptySeriesException
     */
    public function sendSeries(Series $series) {
        if (empty($series->getMetrics())) {
            throw new EmptySeriesException('The series must contain metric data to send');
        }

        $this->send(
            self::ENDPOINT_SERIES . $this->getApiKey(),
            $series->toArray()
        );

        return $this;
    }

    /**
     * @param Event $event
     * @return $this
     */
    public function sendEvent(Event $event) {
        $this->send(
            self::ENDPOINT_EVENT . $this->getApiKey(),
            $event->toArray()
        );

        return $this;
    }

    /**
     * @param $url
     * @param $data
     */
    protected function send($url, $data) {
        $session = curl_init();
        curl_setopt($session, CURLOPT_URL, $url);
        curl_setopt($session, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($session, CURLOPT_HEADER, array('Content-Type: application/json'));
        curl_setopt($session, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

        curl_close($session);
    }
}