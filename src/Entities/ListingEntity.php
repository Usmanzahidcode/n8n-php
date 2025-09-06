<?php

namespace Usman\N8n\Entities;

abstract class ListingEntity {
    /** @var string|null */
    public ?string $nextCursor = null;

    /**
     * Child items (e.g. workflows, users)
     * @var array
     */
    public array $items = [];

    public function __construct(array $response = []) {
        $this->nextCursor = $response['nextCursor'] ?? null;

        $class = $this->getItemClass();
        $this->items = array_map(
            fn($item) => new $class($item),
            $response['data'] ?? []
        );
    }

    /**
     * Each subclass must tell which entity type the list contains.
     * Example: return Workflow::class;
     */
    abstract protected function getItemClass(): string;
}
