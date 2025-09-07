<?php

namespace UsmanZahid\N8n\Entities\User;

use UsmanZahid\N8n\Entities\Entity;

class UserCreateResult extends Entity {
    public ?User $user = null;
    public ?string $error = null;

    protected function getFields(): array {
        return [
            'user' => ['key' => 'user', 'type' => 'object', 'class' => User::class],
            'error' => ['key' => 'error', 'type' => 'string'],
        ];
    }
}
