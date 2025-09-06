<?php

namespace Usman\N8n\Entities\Credential;

use Usman\N8n\Entities\Entity;

class CredentialSchema extends Entity {
    public bool $additionalProperties = false;
    public ?string $type = null;
    public array $properties = [];
    public array $required = [];

    protected function getFields(): array {
        return [
            'additionalProperties' => ['key' => 'additionalProperties', 'type' => 'bool'],
            'type' => ['key' => 'type', 'type' => 'string'],
            'properties' => ['key' => 'properties', 'type' => 'array'],
            'required' => ['key' => 'required', 'type' => 'array'],
        ];
    }
}
