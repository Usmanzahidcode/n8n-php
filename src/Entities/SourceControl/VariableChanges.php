<?php

namespace Usman\N8n\Entities\SourceControl;

use Usman\N8n\Entities\Entity;

class VariableChanges extends Entity {
    public array $added = [];
    public array $changed = [];

    protected function getFields(): array {
        return [
            'added' => ['key' => 'added', 'type' => 'array'],
            'changed' => ['key' => 'changed', 'type' => 'array'],
        ];
    }
}
