<?php

namespace UsmanZahid\N8n\Entities\Project;

use UsmanZahid\N8n\Entities\Entity;

class Project extends Entity {
    public ?string $id = null;
    public ?string $name = null;
    public ?string $type = null;

    protected function getFields(): array {
        return [
            'id' => ['key' => 'id', 'type' => 'string'],
            'name' => ['key' => 'name', 'type' => 'string'],
            'type' => ['key' => 'type', 'type' => 'string'],
        ];
    }
}
