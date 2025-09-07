<?php

namespace UsmanZahid\N8n\Clients\SubClients;

use UsmanZahid\N8n\Clients\ApiClient;
use UsmanZahid\N8n\Entities\Tag\Tag;
use UsmanZahid\N8n\Entities\Tag\TagList;
use UsmanZahid\N8n\Response\N8nResponse;
use UsmanZahid\N8n\Traits\PaginationTrait;

class TagsClient extends ApiClient {
    use PaginationTrait;

    /**
     * Create a tag.
     *
     * @param array{name: string} $payload The payload containing the tag name
     * @return N8nResponse<Tag> The created tag entity
     */
    public function createTag(array $payload): N8nResponse {
        $response = $this->post('/tags', $payload);
        return $this->wrapEntity($response, Tag::class);
    }

    /**
     * Retrieve paginated tags.
     *
     * @param int $limit Maximum number of items to return (default 100)
     * @param string|null $cursor Pagination cursor for next page
     * @return N8nResponse<TagList> Paginated list of tags
     */
    public function listTags(int $limit = 100, ?string $cursor = null): N8nResponse {
        $response = $this->get('/tags', array_filter([
            'limit' => $limit,
            'cursor' => $cursor,
        ]));
        return $this->wrapEntity($response, TagList::class);
    }

    /**
     * Fetch all tags (across all pages).
     *
     * @param int $limit Number of items per page (default 100)
     * @return N8nResponse<TagList> TagList containing all tags
     */
    public function listTagsAll(int $limit = 100): N8nResponse {
        return $this->listAll(
            fn($limit, $cursor) => $this->listTags($limit, $cursor),
            $limit
        );
    }

    /**
     * Append the next page of tags to an existing TagList.
     *
     * @param TagList $list The existing TagList to append to
     * @param int $limit Number of items per page (default 100)
     * @return N8nResponse<TagList> Updated TagList with the next page of tags appended
     */
    public function appendNextTagPage(TagList $list, int $limit = 100): N8nResponse {
        return $this->appendNextPage(
            $list,
            fn($l, $c) => $this->listTags($l, $c),
            $limit
        );
    }

    /**
     * Retrieve a tag by ID.
     *
     * @param string $id The tag ID
     * @return N8nResponse<Tag> The retrieved tag entity
     */
    public function getTag(string $id): N8nResponse {
        $response = $this->get("/tags/{$id}");
        return $this->wrapEntity($response, Tag::class);
    }

    /**
     * Update a tag.
     *
     * @param string $id The tag ID
     * @param array{name: string} $payload The updated payload (e.g. new name)
     * @return N8nResponse<Tag> The updated tag entity
     */
    public function updateTag(string $id, array $payload): N8nResponse {
        $response = $this->put("/tags/{$id}", $payload);
        return $this->wrapEntity($response, Tag::class);
    }

    /**
     * Delete a tag by ID.
     *
     * @param string $id The tag ID
     * @return N8nResponse<Tag> The deleted tag entity
     */
    public function deleteTag(string $id): N8nResponse {
        $response = $this->delete("/tags/{$id}");
        return $this->wrapEntity($response, Tag::class);
    }
}
