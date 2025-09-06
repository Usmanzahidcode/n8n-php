<?php

namespace Usman\N8n\Entities\Tag;

use Usman\N8n\Entities\ListingEntity;

class TagList extends ListingEntity {
    /**
     * @var Tag[] List of tag items
     */
    public array $items = [];

    protected function getItemClass(): string {
        return Tag::class;
    }
}
