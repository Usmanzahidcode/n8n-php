<?php

namespace Usman\N8n\Entities;

class Tag extends Entity {
    public string $name;
    public ?string $id = null;
    public ?string $createdAt = null;
    public ?string $updatedAt = null;

    protected function getFields(): array {
        return [
            'name' => ['key' => 'name', 'type' => 'string'],
            'id' => ['key' => 'id', 'type' => 'string'],
            'createdAt' => ['key' => 'createdAt', 'type' => 'string'],
            'updatedAt' => ['key' => 'updatedAt', 'type' => 'string'],
        ];
    }
}
