<?php

use Usman\N8n\N8nClient;

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createMutable(__DIR__ . '/..', '.env.test');
$dotenv->safeLoad();

// Manual usage testing here :)

N8nClient::connect(
    baseUrl: $_ENV['N8N_BASE_URL'],
    apiKey: $_ENV['N8N_API_KEY']
);

$create = N8nClient::variables()->createVariable([
    'key' => 'test_key',
    'value' => 'test_value',
]);

$list = N8nClient::variables()->listVariables();

$update = N8nClient::variables()->updateVariable($create->id, [
    'key' => 'test_key_updated',
    'value' => 'new_value',
]);

$delete = N8nClient::variables()->deleteVariable($create->id);

var_dump(
    $create,
    $list,
    $update,
    $delete
);