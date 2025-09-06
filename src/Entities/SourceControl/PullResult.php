<?php

namespace Usman\N8n\Entities\SourceControl;

use Usman\N8n\Entities\Entity;

class PullResult extends Entity {
    public array $variables = [];
    public array $credentials = [];
    public array $workflows = [];
    public ?TagsSection $tags = null;

    protected function getFields(): array {
        return [
            'variables' => ['key' => 'variables', 'type' => 'array'],
            'credentials' => ['key' => 'credentials', 'type' => 'array'],
            'workflows' => ['key' => 'workflows', 'type' => 'array'],
            'tags' => ['key' => 'tags', 'type' => TagsSection::class],
        ];
    }
}