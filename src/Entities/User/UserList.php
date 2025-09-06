<?php

namespace Usman\N8n\Entities\User;

use Usman\N8n\Entities\ListingEntity;

class UserList extends ListingEntity {
    /** @var User[] */
    public array $items = [];

    protected function getItemClass(): string {
        return User::class;
    }
}
