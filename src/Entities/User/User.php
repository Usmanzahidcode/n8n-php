<?php

namespace Usman\N8n\Entities\User;

use Usman\N8n\Entities\Entity;

class User extends Entity {
    public string $id;
    public string $email;
    public ?string $firstName = null;
    public ?string $lastName = null;
    public ?bool $isPending = null;
    public ?string $createdAt = null;
    public ?string $updatedAt = null;
    public ?string $role = null;

    protected function getFields(): array {
        return [
            'id' => ['key' => 'id', 'type' => 'string'],
            'email' => ['key' => 'email', 'type' => 'string'],
            'firstName' => ['key' => 'firstName', 'type' => 'string'],
            'lastName' => ['key' => 'lastName', 'type' => 'string'],
            'isPending' => ['key' => 'isPending', 'type' => 'bool'],
            'createdAt' => ['key' => 'createdAt', 'type' => 'string'],
            'updatedAt' => ['key' => 'updatedAt', 'type' => 'string'],
            'role' => ['key' => 'role', 'type' => 'string'],
        ];
    }
}
