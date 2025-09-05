<?php

namespace Usman\N8n\Entities\Workflow;

use Usman\N8n\Entities\Entity;

class Credential extends Entity {
    public string $id;
    public string $name;
    public ?string $type = null;

    protected function getFields(): array {
        return [
            'id' => ['key' => 'id', 'type' => 'string'],
            'name' => ['key' => 'name', 'type' => 'string'],
            'type' => ['key' => 'type', 'type' => 'string'],
        ];
    }
}
