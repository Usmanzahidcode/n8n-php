<?php

namespace Usman\N8n\Entities\Workflow;

use Usman\N8n\Entities\Entity;
use Usman\N8n\Entities\Project;

// Assuming Project entity exists

class Shared extends Entity {
    public string $role;
    public string $workflowId;
    public string $projectId;
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
