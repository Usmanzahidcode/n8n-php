<?php

namespace Usman\N8n\Clients;

use Usman\N8n\BaseClient;

class TagsClient extends BaseClient {
    public function list(): array {
        return $this->get('/tags');
    }

    public function getById(int $id): array {
        return $this->get("/tags/{$id}");
    }

    public function create(string $name): array {
        return $this->post('/tags', ['name' => $name]);
    }

    public function update(int $id, string $name): array {
        return $this->put("/tags/{$id}", ['name' => $name]);
    }

    public function deleteById(int $id): array {
        return $this->delete("/tags/{$id}");
    }
}
