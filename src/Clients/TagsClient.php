<?php

namespace Usman\N8n\Clients;

use Usman\N8n\BaseClient;
use Usman\N8n\Entities\Tag\Tag;
use Usman\N8n\Entities\Tag\TagList;

class TagsClient extends BaseClient {
    /**
     * Create a tag.
     *
     * @param array{name: string} $payload The payload containing the tag name
     * @return Tag The created tag entity
     */
    public function createTag(array $payload): Tag {
        $response = $this->post('/tags', $payload);
        return new Tag($response);
    }

    /**
     * Retrieve all tags.
     *
     * @param int $limit Maximum number of items to return (default 100)
     * @param string|null $cursor Pagination cursor for next page
     * @return TagList Paginated list of tags
     */
    public function listTags(int $limit = 100, ?string $cursor = null): TagList {
        $response = $this->get('/tags', array_filter([
            'limit' => $limit,
            'cursor' => $cursor,
        ]));
        return new TagList($response);
    }

    /**
     * Retrieve a tag by ID.
     *
     * @param string $id The tag ID
     * @return Tag The retrieved tag entity
     */
    public function getTag(string $id): Tag {
        $response = $this->get("/tags/{$id}");
        return new Tag($response);
    }

    /**
     * Update a tag.
     *
     * @param string $id The tag ID
     * @param array{name: string} $payload The updated payload (e.g. new name)
     * @return Tag The updated tag entity
     */
    public function updateTag(string $id, array $payload): Tag {
        $response = $this->put("/tags/{$id}", $payload);
        return new Tag($response);
    }

    /**
     * Delete a tag by ID.
     *
     * @param string $id The tag ID
     * @return Tag The deleted tag entity
     */
    public function deleteTag(string $id): Tag {
        $response = $this->delete("/tags/{$id}");
        return new Tag($response);
    }
}
