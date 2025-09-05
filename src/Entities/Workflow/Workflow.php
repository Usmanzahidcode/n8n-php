<?php

namespace Usman\N8n\Entities\Workflow;

use Usman\N8n\Entities\Entity;
use Usman\N8n\Entities\ProjectEntity;
use Usman\N8n\Entities\WorkflowSettings;

class Workflow extends Entity {
    public string $id;
    public string $name;
    public ?string $workflowId = null;
    public bool $active = false;
    public ?array $nodes = [];
    public ?ProjectEntity $project = null;
    public ?WorkflowSettings $settings = null;
    public ?array $tags = [];
    public ?array $shared = [];
    public ?array $credentials = [];

    protected function getFields(): array {
        return [
            'id' => 'string',
            'name' => 'string',
            'workflowId' => 'string',
            'active' => 'bool',
            'nodes' => ['class' => \stdClass::class],
            'project' => \stdClass::class,
            'settings' => \stdClass::class,
            'tags' => ['class' => \stdClass::class],
            'shared' => ['class' => \stdClass::class],
            'credentials' => ['class' => \stdClass::class],
        ];
    }
}
