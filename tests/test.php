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

$tagsClient = N8nClient::executions();

$page = $tagsClient->listExecutions();
$executionList = $page->data;

// TODO: hasMore() method must handle if the listing is null.
while ($tagsClient->hasMore($executionList)) {
    $tagsClient->appendNextExecutionPage($executionList);
}

foreach ($executionList->items as $execution) {
    echo $execution->mode, PHP_EOL;
}
