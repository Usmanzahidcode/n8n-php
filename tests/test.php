<?php

use Usman\N8n\N8nClient;

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createMutable(__DIR__ . '/..', '.env.test');
$dotenv->safeLoad();

N8nClient::connect(
    baseUrl: $_ENV['N8N_BASE_URL'],
    apiKey: $_ENV['N8N_API_KEY']
);

$execution = N8nClient::credentials()->deleteCredential("HtmuVykrpaiUfsRV");
$execution1 = N8nClient::credentials()->deleteCredential("OJ0S2LOQRCCMJvJm");

var_dump(
    $execution,
    $execution1
);