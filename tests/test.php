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

$tag = N8nClient::tags()->createTag(['name' => 'PragmaticTag1']);
$tagList = N8nClient::tags()->listTags();
$fetchedTag = N8nClient::tags()->getTag($tag->id);
$updatedTag = N8nClient::tags()->updateTag($tag->id, ['name' => 'PragmaticTag2']);
$deletedTag = N8nClient::tags()->deleteTag($tag->id);

var_dump(
    $tag,
    $tagList,
    $fetchedTag,
    $updatedTag,
    $deletedTag
);
