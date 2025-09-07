<?php

namespace UsmanZahid\N8n\Entities\Workflow;

use UsmanZahid\N8n\Entities\ListingEntity;

class WorkflowList extends ListingEntity {
    /** @var Workflow[] */
    public array $items = [];

    protected function getItemClass(): string {
        return Workflow::class;
    }
}
