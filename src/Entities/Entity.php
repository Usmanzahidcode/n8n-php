<?php

namespace Usman\N8n\Entities;

abstract class Entity {
    public function __construct(array $data = []) {
        foreach ($this->getFields() as $property => $definition) {
            $key = $definition['key'] ?? $property;
            $type = $definition['type'] ?? 'string';
            $class = $definition['class'] ?? null;

            // If value not present skip...
            // Will use the default value
            $value = $data[$key] ?? null;
            if ($value===null) {
                continue;
            }

            switch ($type) {
                case 'string':
                case 'int':
                case 'float':
                case 'bool':
                    settype($value, $type);
                    $this->$property = $value;
                    break;

                case 'object':
                    $this->$property = new $class($value);
                    break;

                case 'array':
                    if ($class) {
                        // array of objects
                        $this->$property = array_map(fn($item) => new $class($item), $value);
                    } else {
                        // primitive array
                        $this->$property = $value;
                    }
                    break;

                default:
                    $this->$property = $value;
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
