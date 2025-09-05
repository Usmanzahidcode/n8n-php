<?php

namespace Usman\N8n\Entities\Workflow;

use Usman\N8n\Entities\Credential;
use Usman\N8n\Entities\Entity;
use Usman\N8n\Entities\Node;
use Usman\N8n\Entities\Project;
use Usman\N8n\Entities\Tag;

class Workflow extends Entity {
    public string $id;
    public string $name;
    public ?string $workflowId = null;
    public bool $active = false;
    public ?bool $disabled = null;
    public ?bool $executeOnce = null;
    public ?int $maxTries = null;
    public ?bool $retryOnFail = null;
    public ?string $type = null;
    public ?int $typeVersion = null;
    public ?int $waitBetweenTries = null;
    public ?string $webhookId = null;
    public ?string $notesInFlow = null;

    public ?string $createdAt = null;
    public ?string $updatedAt = null;

    // Nested entities
    public ?WorkflowSettings $settings = null;
    public ?Project $project = null;

    /** @var Node[] */
    public array $nodes = [];

    /** @var Tag[] */
    public array $tags = [];

    /** @var SharedUser[] */
    public array $shared = [];

    /** @var Credential[] */
    public array $credentials = [];

    protected function getFields(): array {
        return [
            'id' => ['key' => 'id', 'type' => 'string'],
            'name' => ['key' => 'name', 'type' => 'string'],
            'workflowId' => ['key' => 'workflowId', 'type' => 'string'],
            'active' => ['key' => 'active', 'type' => 'bool'],
            'disabled' => ['key' => 'disabled', 'type' => 'bool'],
            'executeOnce' => ['key' => 'executeOnce', 'type' => 'bool'],
            'maxTries' => ['key' => 'maxTries', 'type' => 'int'],
            'retryOnFail' => ['key' => 'retryOnFail', 'type' => 'bool'],
            'type' => ['key' => 'type', 'type' => 'string'],
            'typeVersion' => ['key' => 'typeVersion', 'type' => 'int'],
            'waitBetweenTries' => ['key' => 'waitBetweenTries', 'type' => 'int'],
            'webhookId' => ['key' => 'webhookId', 'type' => 'string'],
            'notesInFlow' => ['key' => 'notesInFlow', 'type' => 'string'],

            'createdAt' => ['key' => 'createdAt', 'type' => 'string'],
            'updatedAt' => ['key' => 'updatedAt', 'type' => 'string'],

            'settings' => ['key' => 'settings', 'type' => 'object', 'class' => WorkflowSettings::class],
            'project' => ['key' => 'project', 'type' => 'object', 'class' => Project::class],
            'nodes' => ['key' => 'nodes', 'type' => 'array', 'class' => Node::class],
            'tags' => ['key' => 'tags', 'type' => 'array', 'class' => Tag::class],
            'shared' => ['key' => 'shared', 'type' => 'array', 'class' => SharedUser::class],
            'credentials' => ['key' => 'credentials', 'type' => 'array', 'class' => Credential::class],
        ];
    }
}
