<?php

use Usman\N8n\N8nClient;

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createMutable(__DIR__ . '/..', '.env.test');
$dotenv->safeLoad();

// Raw Testing :)
// Write usage code here and test it by running  through the php command

N8nClient::connect(
    apiBaseUrl: $_ENV['N8N_API_BASE_URL'],
    apiKey: $_ENV['N8N_API_KEY'],
);

$audit = N8nClient::workflows()->listWorkflows();
var_dump($audit);