<?php

namespace Usman\N8n\Clients;

use Usman\N8n\BaseClient;

class CredentialsClient extends BaseClient {
    public function createCredential(array $payload): array {
        return $this->post('/credentials', $payload);
    }

    public function listCredentials(int $limit = 100, ?string $cursor = null): array {
        return $this->get('/credentials', array_filter([
            'limit' => $limit,
            'cursor' => $cursor,
        ]));
    }

    public function getCredential(string $id): array {
        return $this->get("/credentials/{$id}");
    }

    public function deleteCredential(string $id): array {
        return $this->delete("/credentials/{$id}");
    }

    public function schema(string $typeName): array {
        return $this->get("/credentials/schema/{$typeName}");
    }

    public function transferCredential(string $id, string $destinationProjectId): array {
        return $this->put("/credentials/{$id}/transfer", [
            'destinationProjectId' => $destinationProjectId,
        ]);
    }
}