<?php

namespace Usman\N8n\Entities\Workflow;

use Usman\N8n\Entities\ListingEntity;

class WorkflowList extends ListingEntity {
    /** @var Workflow[] */
    public array $items = [];

    protected function getItemClass(): string {
        return Workflow::class;
    }
}
