<?php

namespace Usman\N8n\Clients;

use Usman\N8n\BaseClient;

class TagsClient extends BaseClient {
    public function createTag(array $payload): array {
        return $this->post('/tags', $payload);
    }

    public function listTags(int $limit = 100, ?string $cursor = null): array {
        return $this->get('/tags', array_filter([
            'limit' => $limit,
            'cursor' => $cursor,
        ]));
    }

    public function getTag(string $id): array {
        return $this->get("/tags/{$id}");
    }

    public function updateTag(string $id, array $payload): array {
        return $this->put("/tags/{$id}", $payload);
    }

    public function deleteTag(string $id): array {
        return $this->delete("/tags/{$id}");
    }

    public function getTagById(string $id): array {
        return $this->get($id);
    }

    public function deleteTagById(string $id): array {
        return $this->delete($id);
    }
}