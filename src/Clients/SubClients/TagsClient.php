<?php

namespace Usman\N8n\Clients\SubClients;

use Usman\N8n\Clients\ApiClient;
use Usman\N8n\Entities\Tag\Tag;
use Usman\N8n\Entities\Tag\TagList;
use Usman\N8n\Response\N8nResponse;

class TagsClient extends ApiClient {
    /**
     * Create a tag.
     *
     * @param array{name: string} $payload The payload containing the tag name
     * @return N8nResponse The created tag entity
     */
    public function createTag(array $payload): N8NResponse {
        $response = $this->post('/tags', $payload);
        return $this->wrapEntity($response, Tag::class);
    }

    /**
     * Retrieve all tags.
     *
     * @param int $limit Maximum number of items to return (default 100)
     * @param string|null $cursor Pagination cursor for next page
     * @return N8nResponse Paginated list of tags
     */
    public function listTags(int $limit = 100, ?string $cursor = null): N8NResponse {
        $response = $this->get('/tags', array_filter([
            'limit' => $limit,
            'cursor' => $cursor,
        ]));
        return $this->wrapEntity($response, TagList::class);
    }

    /**
     * Retrieve a tag by ID.
     *
     * @param string $id The tag ID
     * @return N8nResponse The retrieved tag entity
     */
    public function getTag(string $id): N8NResponse {
        $response = $this->get("/tags/{$id}");
        return $this->wrapEntity($response, Tag::class);
    }

    /**
     * Update a tag.
     *
     * @param string $id The tag ID
     * @param array{name: string} $payload The updated payload (e.g. new name)
     * @return N8nResponse The updated tag entity
     */
    public function updateTag(string $id, array $payload): N8NResponse {
        $response = $this->put("/tags/{$id}", $payload);
        return $this->wrapEntity($response, Tag::class);
    }

    /**
     * Delete a tag by ID.
     *
     * @param string $id The tag ID
     * @return N8nResponse The deleted tag entity
     */
    public function deleteTag(string $id): N8NResponse {
        $response = $this->delete("/tags/{$id}");
        return $this->wrapEntity($response, Tag::class);
    }
}
