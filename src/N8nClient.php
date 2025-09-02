<?php

namespace Usman\N8n;

use Usman\N8n\Clients\AuditClient;
use Usman\N8n\Clients\CredentialsClient;
use Usman\N8n\Clients\ExecutionsClient;
use Usman\N8n\Clients\ProjectsClient;
use Usman\N8n\Clients\SourceControlClient;
use Usman\N8n\Clients\TagsClient;
use Usman\N8n\Clients\UsersClient;
use Usman\N8n\Clients\VariablesClient;
use Usman\N8n\Clients\WebhooksClient;
use Usman\N8n\Clients\WorkflowsClient;
use Usman\N8n\Enums\RequestMethod;

class N8nClient {
    private static ?string $apiBaseUrl = null;
    private static ?string $webhookBaseUrl = null;
    private static ?string $apiKey = null;
    private static ?string $webhookUsername = null;
    private static ?string $webhookPassword = null;

    public static function connect(
        string  $apiBaseUrl,
        string  $apiKey,
        ?string $webhookBaseUrl = null,
        ?string $webhookUsername = null,
        ?string $webhookPassword = null
    ): void {
        self::$apiBaseUrl = rtrim($apiBaseUrl, '/');
        self::$apiKey = $apiKey;
        self::$webhookBaseUrl = $webhookBaseUrl ? rtrim($webhookBaseUrl, '/'):null;
        self::$webhookUsername = $webhookUsername;
        self::$webhookPassword = $webhookPassword;
    }

    public static function webhooks(RequestMethod $method = RequestMethod::Post): WebhooksClient {
        self::ensureWebhookConnected();
        return new WebhooksClient(
            self::$webhookBaseUrl,
            $method,
            self::$webhookUsername,
            self::$webhookPassword
        );
    }

    public static function audit(): AuditClient {
        self::ensureConnected();
        return new AuditClient(self::$apiBaseUrl, self::$apiKey);
    }

    public static function credentials(): CredentialsClient {
        self::ensureConnected();
        return new CredentialsClient(self::$apiBaseUrl, self::$apiKey);
    }

    public static function executions(): ExecutionsClient {
        self::ensureConnected();
        return new ExecutionsClient(self::$apiBaseUrl, self::$apiKey);
    }

    public static function workflows(): WorkflowsClient {
        self::ensureConnected();
        return new WorkflowsClient(self::$apiBaseUrl, self::$apiKey);
    }

    public static function tags(): TagsClient {
        self::ensureConnected();
        return new TagsClient(self::$apiBaseUrl, self::$apiKey);
    }

    public static function users(): UsersClient {
        self::ensureConnected();
        return new UsersClient(self::$apiBaseUrl, self::$apiKey);
    }

    public static function variables(): VariablesClient {
        self::ensureConnected();
        return new VariablesClient(self::$apiBaseUrl, self::$apiKey);
    }

    public static function projects(): ProjectsClient {
        self::ensureConnected();
        return new ProjectsClient(self::$apiBaseUrl, self::$apiKey);
    }

    public static function sourceControl(): SourceControlClient {
        self::ensureConnected();
        return new SourceControlClient(self::$apiBaseUrl, self::$apiKey);
    }

    private static function ensureConnected(): void {
        if (!self::$apiBaseUrl || !self::$apiKey) {
            throw new \RuntimeException("N8nClient not connected. Call connect() first with API credentials.");
        }
    }

    private static function ensureWebhookConnected(): void {
        if (!self::$webhookBaseUrl) {
            throw new \RuntimeException("Webhook base URL not configured. Call connect() with webhook URL first.");
        }
    }
}