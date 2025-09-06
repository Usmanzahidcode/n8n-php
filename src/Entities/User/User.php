<?php

namespace Usman\N8n\Entities\User;

use Usman\N8n\Entities\Entity;

class User extends Entity {
    public string $id;
    public string $email;
    public string $firstName;
    public string $lastName;
    public bool $isPending;
    public string $createdAt;
    public string $updatedAt;
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
