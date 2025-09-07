<?php

namespace UsmanZahid\N8n\Entities\Audit;

use UsmanZahid\N8n\Entities\Entity;

class RiskReport extends Entity {
    public ?string $risk = null;
    /** @var Section[] */
    public array $sections = [];

    protected function getFields(): array {
        return [
            'risk' => ['key' => 'risk', 'type' => 'string'],
            'sections' => ['key' => 'sections', 'type' => 'array', 'class' => Section::class],
        ];
    }
}
