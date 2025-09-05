<?php

namespace Usman\N8n\Entities\Audit;

use Usman\N8n\Entities\Entity;

class Section extends Entity {
    public string $title;
    public string $description;
    public ?string $recommendation = null;
    /** @var Location[] */
    public array $locations = [];

    protected function getFields(): array {
        return [
            'title' => ['key' => 'title', 'type' => 'string'],
            'description' => ['key' => 'description', 'type' => 'string'],
            'recommendation' => ['key' => 'recommendation', 'type' => 'string'],
            'locations' => ['key' => 'location', 'type' => 'array', 'class' => Location::class],
        ];
    }
}
