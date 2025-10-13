<?php

use UsmanZahid\N8n\N8nClient;

require_once __DIR__ . '/../vendor/autoload.php';

// ENV setup
$dotenv = Dotenv\Dotenv::createMutable(__DIR__ . '/..', '.env.test');
$dotenv->safeLoad();

// Connect the client
N8nClient::connect(
    baseUrl: $_ENV['N8N_BASE_URL'],
    apiKey: $_ENV['N8N_API_KEY']
);

// Manual usage testing here :)

$webhooksClient = N8nClient::webhook();

$response = $webhooksClient->send(
    "295de809-8b93-45ec-ad83-7179f6693747",
);

dd($response);
