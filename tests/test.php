<?php

use Usman\N8n\Enums\WebhookMode;
use Usman\N8n\N8nClient;

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createMutable(__DIR__ . '/..', '.env.test');
$dotenv->safeLoad();

// Raw Testing :)
// Write usage code here and test it by running  through the php command

N8nClient::connect(
    baseUrl: $_ENV['N8N_BASE_URL'],
    apiKey: $_ENV['N8N_API_KEY']
);

$response = N8nClient::webhooks(WebhookMode::Test)->request("b3b5b1f5-e48a-4d63-8935-f1103cd5f1c6");

var_dump($response);