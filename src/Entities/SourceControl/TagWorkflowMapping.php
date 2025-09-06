<?php

namespace Usman\N8n\Entities\SourceControl;

use Usman\N8n\Entities\Entity;

class TagWorkflowMapping extends Entity {
    public ?string $workflowId = null;
    public ?string $tagId = null;

    protected function getFields(): array {
        return [
            'workflowId' => ['key' => 'workflowId', 'type' => 'string'],
            'tagId' => ['key' => 'tagId', 'type' => 'string'],
        ];
    }
}
