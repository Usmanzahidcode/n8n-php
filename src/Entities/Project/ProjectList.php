<?php

namespace UsmanZahid\N8n\Entities\Project;

use UsmanZahid\N8n\Entities\ListingEntity;

class ProjectList extends ListingEntity {
    /**
     * @var Project[] List of projects
     */
    public array $items = [];

    protected function getItemClass(): string {
        return Project::class;
    }
}
