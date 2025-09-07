<?php

namespace UsmanZahid\N8n\Entities\Variable;

use UsmanZahid\N8n\Entities\Entity;

class Variable extends Entity {
    public ?string $id = null;
    public ?string $key = null;
    public ?string $value = null;
    public ?string $type = null;

    protected function getFields(): array {
        return [
            'id' => ['key' => 'id', 'type' => 'string'],
            'key' => ['key' => 'key', 'type' => 'string'],
            'value' => ['key' => 'value', 'type' => 'string'],
            'type' => ['key' => 'type', 'type' => 'string'],
        ];
    }
}
