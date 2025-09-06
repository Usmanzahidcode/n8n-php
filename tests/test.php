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

$create = N8nClient::projects()->createProject([
    'name' => 'Test Project',
]);

$list = N8nClient::projects()->listProjects();

$update = N8nClient::projects()->updateProject($create['id'], [
    'name' => 'Updated Test Project',
]);

$addUsers = N8nClient::projects()->addUsers($create['id'], [
    [
        'userId' => '91765f0d-3b29-45df-adb9-35b23937eb92',
        'role' => 'project:viewer',
    ],
]);

$changeRole = N8nClient::projects()->changeUserRole(
    $create['id'],
    '91765f0d-3b29-45df-adb9-35b23937eb92',
    'project:editor'
);

$deleteUser = N8nClient::projects()->deleteUser(
    $create['id'],
    '91765f0d-3b29-45df-adb9-35b23937eb92'
);

$deleteProject = N8nClient::projects()->deleteProject($create['id']);

var_dump(
    $create,
    $list,
    $update,
    $addUsers,
    $changeRole,
    $deleteUser,
    $deleteProject
);