<?php

namespace Usman\N8n\Entities\Workflow;

use Usman\N8n\Entities\Entity;

class Workflow extends Entity {
    public string $id;
    public string $name;
    public ?string $workflowId = null;
    public bool $active = false;
    public ?array $nodes = [];
    public ?Project $project = null;
    public ?WorkflowSettings $settings = null;
    public ?array $tags = [];
    public ?array $shared = [];
    public ?array $credentials = [];

    protected function getFields(): array {
        return [
            'id' => ['key' => 'id', 'type' => 'string'],
            'name' => ['key' => 'name', 'type' => 'string'],
            'workflowId' => ['key' => 'workflowId', 'type' => 'string'],
            'active' => ['key' => 'active', 'type' => 'bool'],
            'nodes' => ['key' => 'nodes', 'type' => 'array', 'class' => \stdClass::class],
            'project' => ['key' => 'project', 'type' => 'object', 'class' => \stdClass::class],
            'settings' => ['key' => 'settings', 'type' => 'object', 'class' => \stdClass::class],
            'tags' => ['key' => 'tags', 'type' => 'array', 'class' => \stdClass::class],
            'shared' => ['key' => 'shared', 'type' => 'array', 'class' => \stdClass::class],
            'credentials' => ['key' => 'credentials', 'type' => 'array', 'class' => \stdClass::class],
        ];
    }
}
