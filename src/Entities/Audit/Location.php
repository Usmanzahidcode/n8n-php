<?php

namespace Usman\N8n\Entities;

class Location extends Entity
{
    public string $kind;
    public ?string $id = null;
    public ?string $name = null;
    public ?string $workflowId = null;
    public ?string $workflowName = null;
    public ?string $nodeId = null;
    public ?string $nodeName = null;
    public ?string $nodeType = null;
    public ?string $packageUrl = null;

    protected function getFields(): array
    {
        return [
            'kind' => 'string',
            'id' => 'string',
            'name' => 'string',
            'workflowId' => 'string',
            'workflowName' => 'string',
            'nodeId' => 'string',
            'nodeName' => 'string',
            'nodeType' => 'string',
            'packageUrl' => 'string',
        ];
    }
}
