<?php

namespace Unit;

use PHPUnit\Framework\TestCase;
use RuntimeException;
use UsmanZahid\N8n\Clients\SubClients\AuditClient;
use UsmanZahid\N8n\Clients\SubClients\CredentialsClient;
use UsmanZahid\N8n\Clients\SubClients\ExecutionsClient;
use UsmanZahid\N8n\Clients\SubClients\ProjectsClient;
use UsmanZahid\N8n\Clients\SubClients\SourceControlClient;
use UsmanZahid\N8n\Clients\SubClients\TagsClient;
use UsmanZahid\N8n\Clients\SubClients\UsersClient;
use UsmanZahid\N8n\Clients\SubClients\VariablesClient;
use UsmanZahid\N8n\Clients\SubClients\WorkflowsClient;
use UsmanZahid\N8n\Clients\WebhookClient;
use UsmanZahid\N8n\Enums\RequestMethod;
use UsmanZahid\N8n\Enums\WebhookMode;
use UsmanZahid\N8n\N8nClient;

class N8nClientTest extends TestCase {
    protected function setUp(): void {
        // reset static state between tests
        $refClass = new \ReflectionClass(N8nClient::class);
        foreach (['baseUrl', 'apiKey', 'webhookUsername', 'webhookPassword'] as $prop) {
            $property = $refClass->getProperty($prop);
            $property->setAccessible(true);
            $property->setValue(null, null);
        }
    }

    public function testThrowsExceptionWhenNotConnected(): void {
        $this->expectException(RuntimeException::class);
        N8nClient::audit();
    }

    public function testThrowsExceptionWhenWebhookBaseUrlMissing(): void {
        $this->expectException(RuntimeException::class);
        N8nClient::webhook();
    }

    public function testConnectSetsUpAndAuditClientIsCreated(): void {
        N8nClient::connect('http://localhost', 'test-key');
        $client = N8nClient::audit();
        $this->assertInstanceOf(AuditClient::class, $client);
    }

    public function testOtherSubClientsAreCreated(): void {
        N8nClient::connect('http://localhost', 'test-key');

        $this->assertInstanceOf(CredentialsClient::class, N8nClient::credentials());
        $this->assertInstanceOf(ExecutionsClient::class, N8nClient::executions());
        $this->assertInstanceOf(WorkflowsClient::class, N8nClient::workflows());
        $this->assertInstanceOf(TagsClient::class, N8nClient::tags());
        $this->assertInstanceOf(UsersClient::class, N8nClient::users());
        $this->assertInstanceOf(VariablesClient::class, N8nClient::variables());
        $this->assertInstanceOf(ProjectsClient::class, N8nClient::projects());
        $this->assertInstanceOf(SourceControlClient::class, N8nClient::sourceControl());
    }

    public function testWebhookClientCreatedAfterConnect(): void {
        N8nClient::connect('http://localhost', 'test-key', 'user', 'pass');
        $client = N8nClient::webhook(WebhookMode::Production, RequestMethod::Post);
        $this->assertInstanceOf(WebhookClient::class, $client);
    }
}
