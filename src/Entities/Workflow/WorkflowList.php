<?php

namespace Usman\N8n\Entities\Workflow;

use Usman\N8n\Entities\Entity;

class WorkflowList extends Entity {
    /** @var Workflow[] */
    public array $workflows = [];

    protected function getFields(): array {
        return [
            'workflows' => ['key' => 'data', 'type' => 'array', 'class' => Workflow::class],
        ];
    }
}
