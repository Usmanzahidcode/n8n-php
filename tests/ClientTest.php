<?php

use PHPUnit\Framework\TestCase;
use Usman\N8n\Clients\UsersClient;
use Usman\N8n\N8nClient;

class ClientTest extends TestCase {
    public function testClientIsCreated() {
        N8nClient::connect(
            apiBaseUrl: "https://example.com",
            apiKey: "dummy-key",
            webhookBaseUrl: "https://example.com/webhook",
            webhookUsername: "user",
            webhookPassword: "pass"
        );

        $client = N8nClient::users();

        $this->assertInstanceOf(UsersClient::class, $client);
    }

    public function testClientWorks() {
        N8nClient::connect(
            apiBaseUrl: getenv('N8N_API_BASE_URL'),
            apiKey: getenv('N8N_API_KEY')
        );

        $client = N8nClient::users();
        $usersList = $client->listUsers();
    }
}
