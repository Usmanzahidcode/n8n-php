<?php

namespace Usman\N8n\Clients;

use Usman\N8n\BaseClient;

class TagsClient extends BaseClient {
    /**
     * Retrieve all tags
     *
     * @param int|null $limit
     * @param string|null $cursor
     * @return array
     */
    public function list(?int $limit = 100, ?string $cursor = null): array {
        $query = [];
        if ($limit!==null) {
            $query['limit'] = $limit;
        }
        if ($cursor!==null) {
            $query['cursor'] = $cursor;
        }

        return $this->get('/tags', $query);
    }

    /**
     * Retrieves a tag by ID
     *
     * @param string $id
     * @return array
     */
    public function getById(string $id): array {
        return $this->get("/tags/{$id}");
    }

    /**
     * Creates a tag
     *
     * @param string $name
     * @return array
     */
    public function create(string $name): array {
        return $this->post('/tags', ['name' => $name]);
    }

    /**
     * Updates a tag by ID
     *
     * @param string $id
     * @param string $name
     * @return array
     */
    public function update(string $id, string $name): array {
        return $this->put("/tags/{$id}", ['name' => $name]);
    }

    /**
     * Deletes a tag by ID
     *
     * @param string $id
     * @return array
     */
    public function deleteById(string $id): array {
        return $this->delete("/tags/{$id}");
    }
}
