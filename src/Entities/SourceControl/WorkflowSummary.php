<?php

namespace Usman\N8n\Entities\SourceControl;

use Usman\N8n\Entities\Entity;

class WorkflowSummary extends Entity {
    public ?string $id = null;
    public ?string $name = null;

    protected function getFields(): array {
        return [
            'id' => ['key' => 'id', 'type' => 'string'],
            'name' => ['key' => 'name', 'type' => 'string'],
        ];
    }
}
