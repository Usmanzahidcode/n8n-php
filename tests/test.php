<?php

use UsmanZahid\N8n\N8nClient;

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createMutable(__DIR__ . '/..', '.env.test');
$dotenv->safeLoad();

// Manual usage testing here :)

N8nClient::connect(
    baseUrl: $_ENV['N8N_BASE_URL'],
    apiKey: $_ENV['N8N_API_KEY']
);

$executionsClient = N8nClient::executions();

//$response = $executionsClient->getExecution(550);
$response = $executionsClient->listExecutions();

if ($response->success) {
    $executionList = $response->data;

    while ($executionsClient->hasMore($executionList)) {
        $executionsClient->appendNextExecutionPage($executionList);
    }

    echo count($executionList->items) . PHP_EOL;

    foreach ($executionList->items as $execution) {
//        echo $execution->status . PHP_EOL;
    }
}
