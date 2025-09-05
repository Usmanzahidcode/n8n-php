<?php

namespace Usman\N8n\Enums;

use InvalidArgumentException;

enum WebhookMode: string {
    case Test = 'test';
    case Production = 'production';

    public function is(string|self $value): bool {
        return $this === self::parse($value);
    }

    public static function parse(string|self $value): self {
        if ($value instanceof self) {
            return $value;
        }

        $value = strtolower($value);

        return match ($value) {
            'test' => self::Test,
            'production', 'prod' => self::Production,
            default => throw new InvalidArgumentException("Unsupported webhook mode [{$value}]"),
        };
    }

    /**
     * Returns the actual prefix used by n8n ("webhook-test" or "webhook").
     */
    public function prefix(): string {
        return $this === self::Test ? '/webhook-test' : '/webhook';
    }
}
