<?php

namespace UsmanZahid\N8n\Entities\SourceControl;

use UsmanZahid\N8n\Entities\Entity;

class PullResult extends Entity {
    /** @var VariableChanges|null */
    public ?VariableChanges $variables = null;

    /** @var CredentialSummary[] */
    public array $credentials = [];

    /** @var WorkflowSummary[] */
    public array $workflows = [];

    /** @var TagMappings|null */
    public ?TagMappings $tags = null;

    /** @var array Arbitrary additional properties returned by API */
    public array $additional = [];

    protected function getFields(): array {
        return [
            'variables' => ['key' => 'variables', 'type' => 'object', 'class' => VariableChanges::class],
            'credentials' => ['key' => 'credentials', 'type' => 'array', 'class' => CredentialSummary::class],
            'workflows' => ['key' => 'workflows', 'type' => 'array', 'class' => WorkflowSummary::class],
            'tags' => ['key' => 'tags', 'type' => 'object', 'class' => TagMappings::class],
            'additional' => ['key' => '*', 'type' => 'array'], // catch-all for any extra properties
        ];
    }
}
