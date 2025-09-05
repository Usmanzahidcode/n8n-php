<?php

use Usman\N8n\Enums\RequestMethod;
use Usman\N8n\N8nClient;

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createMutable(__DIR__ . '/..', '.env.test');
$dotenv->safeLoad();

// Raw Testing :)
// Write usage code here and test it by running  through the php command

N8nClient::connect(
    apiBaseUrl: $_ENV['N8N_API_BASE_URL'],
    apiKey: $_ENV['N8N_API_KEY'],
    webhookBaseUrl: $_ENV['N8N_WEBHOOK_BASE_URL'],
    webhookUsername: $_ENV['N8N_WEBHOOK_USERNAME'],
    webhookPassword: $_ENV['N8N_WEBHOOK_PASSWORD']
);

$response = N8nClient::webhooks(RequestMethod::Get)
    ->withoutBasicAuth()
    ->request("b3b5b1f5-e48a-4d63-8935-f1103cd5f1c6");

var_dump($response);