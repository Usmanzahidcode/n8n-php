<?php

namespace Usman\N8n\Entities;

class Section extends Entity
{
    public string $title;
    public string $description;
    public ?string $recommendation = null;
    /** @var Location[] */
    public array $location = [];

    protected function getFields(): array
    {
        return [
            'title' => 'string',
            'description' => 'string',
            'recommendation' => 'string',
            'location' => ['class' => Location::class],
        ];
    }
}
