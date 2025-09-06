<?php

use Usman\N8n\N8nClient;

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createMutable(__DIR__ . '/..', '.env.test');
$dotenv->safeLoad();

N8nClient::connect(
    baseUrl: $_ENV['N8N_BASE_URL'],
    apiKey: $_ENV['N8N_API_KEY']
);

$users = N8nClient::users();

//$list = $users->listUsers(['limit' => 5]);
//var_dump($list);
//
//$new = $users->createUser([
//    [
//        'email' => 'acblkdhflkdsj123@example.com',
//        'firstName' => 'Test',
//        'lastName' => 'User',
//    ],[
//        'email' => 'lkajsdhflksdjf123@example.com',
//        'firstName' => 'Test',
//        'lastName' => 'User',
//    ]
//]);
//var_dump($new);

//$single = $users->getUser('15f57b56-e334-45a8-a2e3-cdca43418df0', true);
//var_dump($single);

//$role = $users->changeUserRole('test.user@example.com', 'global:member');
//var_dump($role);
//
//$delete = $users->deleteUser('test.user@example.com');
//var_dump($delete);
