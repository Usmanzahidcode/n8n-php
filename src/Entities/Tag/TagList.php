<?php

namespace UsmanZahid\N8n\Entities\Tag;

use UsmanZahid\N8n\Entities\ListingEntity;

class TagList extends ListingEntity {
    /**
     * @var Tag[] List of tag items
     */
    public array $items = [];

    protected function getItemClass(): string {
        return Tag::class;
    }
}
