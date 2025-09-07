<?php

namespace UsmanZahid\N8n\Entities\Project;

use UsmanZahid\N8n\Entities\Entity;

class ProjectUserRelation extends Entity {
    public ?string $userId = null;
    public ?string $role = null;

    protected function getFields(): array {
        return [
            'userId' => ['key' => 'userId', 'type' => 'string'],
            'role' => ['key' => 'role', 'type' => 'string'],
        ];
    }
}
