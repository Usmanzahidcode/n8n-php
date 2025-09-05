<?php

namespace Usman\N8n\Entities;

class RiskReport extends Entity
{
    public string $risk;
    /** @var Section[] */
    public array $sections = [];

    protected function getFields(): array
    {
        return [
            'risk' => 'string',
            'sections' => ['class' => Section::class],
        ];
    }
}
