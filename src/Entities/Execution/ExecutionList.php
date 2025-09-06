<?php

namespace Usman\N8n\Entities\Execution;

use Usman\N8n\Entities\ListingEntity;

class ExecutionList extends ListingEntity {
    /**
     * @var Execution[] List of execution items
     */
    public array $items = [];

    /**
     * @return string The class name of the items contained in the list
     */
    protected function getItemClass(): string {
        return Execution::class;
    }
}
