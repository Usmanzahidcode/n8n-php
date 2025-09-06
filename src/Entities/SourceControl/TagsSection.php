<?php

namespace Usman\N8n\Entities\SourceControl;

use Usman\N8n\Entities\Entity;

class TagsSection extends Entity {
    /** @var TagItem[] */
    public array $tags = [];

    /** @var TagMapping[] */
    public array $mappings = [];

    protected function getFields(): array {
        return [
            'tags' => ['key' => 'tags', 'type' => 'array'],
            'mappings' => ['key' => 'mappings', 'type' => 'array'],
        ];
    }
}