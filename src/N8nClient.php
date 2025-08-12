<?php

namespace Usman\N8n;

class N8nClient {
    private static ?string $baseUrl = null;
    private static ?string $apiKey = null;

    public static function connect(string $baseUrl, string $apiKey): void {
        self::$baseUrl = rtrim($baseUrl, '/');
        self::$apiKey = $apiKey;
    }

    public static function tags(): TagsClient {
        self::ensureConnected();
        return new TagsClient(self::$baseUrl, self::$apiKey);
    }

    public static function workflows(): WorkflowsClient {
        self::ensureConnected();
        return new WorkflowsClient(self::$baseUrl, self::$apiKey);
    }

    private static function ensureConnected(): void {
        if (!self::$baseUrl || !self::$apiKey) {
            throw new \RuntimeException("N8nClient not connected. Call connect() first.");
        }
    }
}