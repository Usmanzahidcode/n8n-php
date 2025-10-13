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
    "b160748e-f4ec-4fe5-8833-3ef264a5f29a",
);

dd($response);
