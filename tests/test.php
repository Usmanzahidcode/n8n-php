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

$tagsClient = N8nClient::tags();

$tagListResponse = $tagsClient->listTags();
$tagList = $tagListResponse->data;

while ($tagsClient->hasMore($tagList)) {
    $tagsClient->appendNextTagPage($tagList);
}