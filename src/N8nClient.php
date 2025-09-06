<?php

namespace Usman\N8n;

use Usman\N8n\Clients\SubClients\AuditClient;
use Usman\N8n\Clients\SubClients\CredentialsClient;
use Usman\N8n\Clients\SubClients\ExecutionsClient;
use Usman\N8n\Clients\SubClients\ProjectsClient;
use Usman\N8n\Clients\SubClients\SourceControlClient;
use Usman\N8n\Clients\SubClients\TagsClient;
use Usman\N8n\Clients\SubClients\UsersClient;
use Usman\N8n\Clients\SubClients\VariablesClient;
use Usman\N8n\Clients\SubClients\WorkflowsClient;
use Usman\N8n\Clients\WebhookClient;
use Usman\N8n\Enums\RequestMethod;
use Usman\N8n\Enums\WebhookMode;

class N8nClient {
    private static ?string $baseUrl = null;
    private static ?string $apiKey = null;
    private static ?string $webhookUsername = null;
    private static ?string $webhookPassword = null;

    public static function connect(
        string  $baseUrl,
        string  $apiKey,
        ?string $webhookUsername = null,
        ?string $webhookPassword = null
    ): void {
        self::$baseUrl = $baseUrl;
        self::$apiKey = $apiKey;
        self::$webhookUsername = $webhookUsername;
        self::$webhookPassword = $webhookPassword;
    }

    public static function webhook(
        WebhookMode   $mode = WebhookMode::Production,
        RequestMethod $method = RequestMethod::Post
    ): WebhookClient {
        self::ensureWebhookConnected();
        return new WebhookClient(
            self::$baseUrl,
            $mode,
            $method,
            self::$webhookUsername,
            self::$webhookPassword
        );
    }

    public static function audit(): AuditClient {
        self::ensureConnected();
        return new AuditClient(self::$baseUrl, self::$apiKey);
    }

    public static function credentials(): CredentialsClient {
        self::ensureConnected();
        return new CredentialsClient(self::$baseUrl, self::$apiKey);
    }

    public static function executions(): ExecutionsClient {
        self::ensureConnected();
        return new ExecutionsClient(self::$baseUrl, self::$apiKey);
    }

    public static function workflows(): WorkflowsClient {
        self::ensureConnected();
        return new WorkflowsClient(self::$baseUrl, self::$apiKey);
    }

    public static function tags(): TagsClient {
        self::ensureConnected();
        return new TagsClient(self::$baseUrl, self::$apiKey);
    }

    public static function users(): UsersClient {
        self::ensureConnected();
        return new UsersClient(self::$baseUrl, self::$apiKey);
    }

    public static function variables(): VariablesClient {
        self::ensureConnected();
        return new VariablesClient(self::$baseUrl, self::$apiKey);
    }

    public static function projects(): ProjectsClient {
        self::ensureConnected();
        return new ProjectsClient(self::$baseUrl, self::$apiKey);
    }

    public static function sourceControl(): SourceControlClient {
        self::ensureConnected();
        return new SourceControlClient(self::$baseUrl, self::$apiKey);
    }

    private static function ensureConnected(): void {
        if (!self::$baseUrl || !self::$apiKey) {
            throw new \RuntimeException("N8nClient not connected. Call connect() first with API credentials.");
        }
    }

    private static function ensureWebhookConnected(): void {
        if (!self::$baseUrl) {
            throw new \RuntimeException("Webhook base URL not configured. Call connect() with webhook URL first.");
        }
    }
}