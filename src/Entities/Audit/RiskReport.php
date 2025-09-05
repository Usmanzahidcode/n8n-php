<?php

namespace Usman\N8n\Entities\Audit;

use Usman\N8n\Entities\Entity;

class RiskReport extends Entity {
    public string $risk;
    /** @var Section[] */
    public array $sections = [];

    protected function getFields(): array {
        return [
            'risk' => ['key' => 'risk', 'type' => 'string'],
            'sections' => ['key' => 'sections', 'type' => 'array', 'class' => Section::class],
        ];
    }
}
