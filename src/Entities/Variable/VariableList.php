<?php

namespace UsmanZahid\N8n\Entities\Variable;

use UsmanZahid\N8n\Entities\ListingEntity;

class VariableList extends ListingEntity {
    /**
     * @var Variable[]
     */
    public array $items = [];

    protected function getItemClass(): string {
        return Variable::class;
    }
}
