<?php

use PHPUnit\Framework\TestCase;
use UsmanZahid\N8n\N8nClient;

class ClientTest extends TestCase {
    public function testClientWorks() {
        N8nClient::connect(
            baseUrl: $_ENV['N8N_API_BASE_URL'] ?? "",
            apiKey: $_ENV['N8N_API_KEY'] ?? "",
        );

        try {
            $client = N8nClient::workflows();
            $usersList = $client->listWorkflows();

            var_dump($usersList['nextCursor']);
        } catch (Throwable $e) {
            var_dump($e->getMessage());
        }
    }
}
