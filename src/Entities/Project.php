<?php

namespace Usman\N8n\Entities;

class Project extends Entity {
    public string $id;
    public string $name;
    public ?string $type = null;
    public ?string $projectId = null;
    public ?string $role = null;
    public ?string $updatedAt = null;

    protected function getFields(): array {
        return [
            'id' => ['key' => 'id', 'type' => 'string'],
            'name' => ['key' => 'name', 'type' => 'string'],
            'type' => ['key' => 'type', 'type' => 'string'],
            'projectId' => ['key' => 'projectId', 'type' => 'string'],
            'role' => ['key' => 'role', 'type' => 'string'],
            'updatedAt' => ['key' => 'updatedAt', 'type' => 'string'],
        ];
    }
}
