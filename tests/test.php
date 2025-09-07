<?php

use Usman\N8n\N8nClient;

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createMutable(__DIR__ . '/..', '.env.test');
$dotenv->safeLoad();

// Manual usage testing here :)
// Test cases to be added :(

N8nClient::connect(
    baseUrl: $_ENV['N8N_BASE_URL'],
    apiKey: $_ENV['N8N_API_KEY']
);

$tagsClient = N8nClient::tags();

$page = $tagsClient->listTags();
$tagList = $page->data;

while ($tagsClient->hasMore($tagList)) {
    $tagsClient->appendNextTagPage($tagList);
}

foreach ($tagList->items as $tag) {
    echo $tag->name, PHP_EOL;
}
