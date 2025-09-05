<?php

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createMutable(__DIR__ . '/..', '.env.test');
$dotenv->safeLoad();

// Raw Testing :)
// Write usage code here and test it by running  through the php command
