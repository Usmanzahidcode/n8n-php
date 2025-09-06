<?php

namespace Usman\N8n\Entities\Audit;

use Usman\N8n\Entities\Entity;

class Location extends Entity {
    public ?string $kind = null;
    public ?string $id = null;
    public ?string $name = null;
    public ?string $workflowId = null;
    public ?string $workflowName = null;
    public ?string $nodeId = null;
    public ?string $nodeName = null;
    public ?string $nodeType = null;
    public ?string $packageUrl = null;

    protected function getFields(): array {
        return [
            'kind' => ['key' => 'kind', 'type' => 'string'],
            'id' => ['key' => 'id', 'type' => 'string'],
            'name' => ['key' => 'name', 'type' => 'string'],
            'workflowId' => ['key' => 'workflowId', 'type' => 'string'],
            'workflowName' => ['key' => 'workflowName', 'type' => 'string'],
            'nodeId' => ['key' => 'nodeId', 'type' => 'string'],
            'nodeName' => ['key' => 'nodeName', 'type' => 'string'],
            'nodeType' => ['key' => 'nodeType', 'type' => 'string'],
            'packageUrl' => ['key' => 'packageUrl', 'type' => 'string'],
        ];
    }
}
