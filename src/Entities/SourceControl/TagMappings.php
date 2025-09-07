<?php

namespace UsmanZahid\N8n\Entities\SourceControl;

use UsmanZahid\N8n\Entities\Entity;

class TagMappings extends Entity {
    /** @var TagItem[] */
    public array $tags = [];

    /** @var TagWorkflowMapping[] */
    public array $mappings = [];

    protected function getFields(): array {
        return [
            'tags' => ['key' => 'tags', 'type' => 'array', 'class' => TagItem::class],
            'mappings' => ['key' => 'mappings', 'type' => 'array', 'class' => TagWorkflowMapping::class],
        ];
    }
}
