<?php

// Autoload files using composer
$loader = require_once(__DIR__ . '/../vendor/autoload.php');

use Bayer\DataDogClient\Client;

new Client();