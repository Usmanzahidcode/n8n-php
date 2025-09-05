<?php

namespace Usman\N8n\Entities\Workflow;

use Usman\N8n\Entities\Entity;

class SharedUser extends Entity {
    public string $id;
    public string $role;
    public ?string $projectId = null;
    public ?string $name = null;
    public ?string $createdAt = null;
    public ?string $updatedAt = null;

    protected function getFields(): array {
        return [
            'id' => ['key' => 'id', 'type' => 'string'],
            'role' => ['key' => 'role', 'type' => 'string'],
            'projectId' => ['key' => 'projectId', 'type' => 'string'],
            'name' => ['key' => 'name', 'type' => 'string'],
            'createdAt' => ['key' => 'createdAt', 'type' => 'string'],
            'updatedAt' => ['key' => 'updatedAt', 'type' => 'string'],
        ];
    }
}
