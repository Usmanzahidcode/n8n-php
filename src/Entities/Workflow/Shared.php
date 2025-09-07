<?php

namespace UsmanZahid\N8n\Entities\Workflow;

use UsmanZahid\N8n\Entities\Entity;
use UsmanZahid\N8n\Entities\Project\Project;

class Shared extends Entity {
    public ?string $role = null;
    public ?string $workflowId = null;
    public ?string $projectId = null;
    public ?Project $project = null;
    public ?string $createdAt = null;
    public ?string $updatedAt = null;

    protected function getFields(): array {
        return [
            'role' => ['key' => 'role', 'type' => 'string'],
            'workflowId' => ['key' => 'workflowId', 'type' => 'string'],
            'projectId' => ['key' => 'projectId', 'type' => 'string'],
            'project' => ['key' => 'project', 'type' => 'object', 'class' => Project::class],
            'createdAt' => ['key' => 'createdAt', 'type' => 'string'],
            'updatedAt' => ['key' => 'updatedAt', 'type' => 'string'],
        ];
    }
}
