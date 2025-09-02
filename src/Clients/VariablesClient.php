<?php

namespace Usman\N8n\Clients;

use Usman\N8n\BaseClient;

class VariablesClient extends BaseClient {
    public function createVariable(array $payload): array {
        return $this->post('/variables', $payload);
    }

    public function listVariables(int $limit = 100, ?string $cursor = null): array {
        return $this->get('/variables', array_filter([
            'limit' => $limit,
            'cursor' => $cursor,
        ]));
    }

    public function deleteVariable(string $id): array {
        return $this->delete("/variables/{$id}");
    }

    public function updateVariable(string $id, array $payload): array {
        return $this->put("/variables/{$id}", $payload);
    }
}