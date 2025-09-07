<?php

namespace UsmanZahid\N8n\Entities\Credential;

use UsmanZahid\N8n\Entities\Entity;

class Credential extends Entity {
    public ?string $id = null;
    public ?string $name = null;
    public ?string $type = null;
    public ?string $createdAt = null;
    public ?string $updatedAt = null;

    protected function getFields(): array {
        return [
            'id' => ['key' => 'id', 'type' => 'string'],
            'name' => ['key' => 'name', 'type' => 'string'],
            'type' => ['key' => 'type', 'type' => 'string'],
            'createdAt' => ['key' => 'createdAt', 'type' => 'string'],
            'updatedAt' => ['key' => 'updatedAt', 'type' => 'string'],
        ];
    }
}
