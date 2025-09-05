<?php

namespace Usman\N8n\Entities\Workflow;

use Usman\N8n\Entities\Entity;

class Workflow extends Entity {
    public string $id;
    public string $name;
    public bool $active = false;
    public bool $isArchived = false;

    public ?string $createdAt = null;
    public ?string $updatedAt = null;

    /** @var Node[] */
    public array $nodes = [];

    /** @var array Connections between nodes */
    public array $connections = [];

    /** @var WorkflowSettings|null */
    public ?WorkflowSettings $settings = null;

    /** @var array Static data for workflow */
    public array $staticData = [];

    /** @var array Meta information */
    public array $meta = [];

    /** @var array Pin data */
    public array $pinData = [];

    /** @var string|null Version ID */
    public ?string $versionId = null;

    /** @var int Trigger count */
    public int $triggerCount = 0;

    /** @var Shared[] */
    public array $shared = [];

    /** @var Tag[] */
    public array $tags = [];

    protected function getFields(): array {
        return [
            'id' => ['key' => 'id', 'type' => 'string'],
            'name' => ['key' => 'name', 'type' => 'string'],
            'active' => ['key' => 'active', 'type' => 'bool'],
            'isArchived' => ['key' => 'isArchived', 'type' => 'bool'],

            'createdAt' => ['key' => 'createdAt', 'type' => 'string'],
            'updatedAt' => ['key' => 'updatedAt', 'type' => 'string'],

            'nodes' => ['key' => 'nodes', 'type' => 'array', 'class' => Node::class],
            'connections' => ['key' => 'connections', 'type' => 'array'],
            'settings' => ['key' => 'settings', 'type' => 'object', 'class' => WorkflowSettings::class],
            'staticData' => ['key' => 'staticData', 'type' => 'array'],
            'meta' => ['key' => 'meta', 'type' => 'array'],
            'pinData' => ['key' => 'pinData', 'type' => 'array'],
            'versionId' => ['key' => 'versionId', 'type' => 'string'],
            'triggerCount' => ['key' => 'triggerCount', 'type' => 'int'],
            'shared' => ['key' => 'shared', 'type' => 'array', 'class' => Shared::class],
            'tags' => ['key' => 'tags', 'type' => 'array', 'class' => Tag::class],
        ];
    }
}
