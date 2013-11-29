<?php

namespace Bayer\DataDogClient;

class Client {
    protected $apiKey;
    protected $applicationKey;

    public function __construct($apiKey, $applicationKey = null) {
        $this->apiKey         = $apiKey;
        $this->applicationKey = $applicationKey;
    }
}