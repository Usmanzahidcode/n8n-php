<?php

namespace UsmanZahid\N8n\Enums;

use InvalidArgumentException;

enum RequestMethod: string {
    case Get = 'GET';
    case Post = 'POST';
    case Put = 'PUT';
    case Delete = 'DELETE';
    case Patch = 'PATCH';
    case Head = 'HEAD';

    public static function parse(string|self $value): self {
        if ($value instanceof self) {
            return $value;
        }
        $value = strtoupper($value);
        return self::tryFrom($value)
            ?? throw new InvalidArgumentException("Unsupported HTTP method [{$value}]");
    }

    /**
     * True when the given value refers to **this** method.
     */
    public function is(string|self $value): bool {
        return $this===self::parse($value);
    }
}