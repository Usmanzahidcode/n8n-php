<?php

namespace Usman\N8n\Entities\Workflow;

use Usman\N8n\Entities\Entity;

class Node extends Entity {
    public string $id;
    public string $name;
    public string $type;
    public ?array $position = [];
    public ?bool $alwaysOutputData = null;
    public ?bool $continueOnFail = null;
    public ?string $onError = null;
    public ?array $parameters = [];

    protected function getFields(): array {
        return [
            'id' => ['key' => 'id', 'type' => 'string'],
            'name' => ['key' => 'name', 'type' => 'string'],
            'type' => ['key' => 'type', 'type' => 'string'],
            'position' => ['key' => 'position', 'type' => 'array'],
            'alwaysOutputData' => ['key' => 'alwaysOutputData', 'type' => 'bool'],
            'continueOnFail' => ['key' => 'continueOnFail', 'type' => 'bool'],
            'onError' => ['key' => 'onError', 'type' => 'string'],
            'parameters' => ['key' => 'parameters', 'type' => 'array'],
        ];
    }
}
