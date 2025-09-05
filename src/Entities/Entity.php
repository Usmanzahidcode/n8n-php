<?php

namespace Usman\N8n\Entities;

abstract class Entity {
    public function __construct(array $data = []) {
        foreach ($this->getFields() as $field => $type) {
            $value = $data[$field] ?? null;

            // handle nested single entity
            if (is_string($type) && class_exists($type) && is_array($value)) {
                $this->$field = new $type($value);
            } // handle array of entities
            elseif (is_array($type) && isset($type['class']) && $value!==null) {
                $this->$field = array_map(fn($item) => new $type['class']($item), $value);
            } else {
                $this->$field = $value;
            }
        }
    }

    /**
     * Return an array mapping field names to their types or sub-entities
     * Example:
     * return [
     *   'id' => 'string',
     *   'project' => ProjectEntity::class,
     *   'nodes' => ['class' => NodeEntity::class],
     * ];
     */
    abstract protected function getFields(): array;
}
