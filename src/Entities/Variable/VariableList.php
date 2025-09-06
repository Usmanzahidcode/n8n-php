<?php

namespace Usman\N8n\Entities\Variable;

use Usman\N8n\Entities\ListingEntity;

class VariableList extends ListingEntity {
    /**
     * @var Variable[]
     */
    public array $items = [];

    protected function getItemClass(): string {
        return Variable::class;
    }
}
