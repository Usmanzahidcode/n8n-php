<?php

namespace Usman\N8n\Clients;

use Usman\N8n\BaseClient;

class ProjectsClient extends BaseClient {
    public function create(array $payload): array {
        return $this->post('/projects', $payload);
    }

    public function list(int $limit = 100, ?string $cursor = null): array {
        return $this->get('/projects', array_filter([
            'limit' => $limit,
            'cursor' => $cursor,
        ]));
    }

    public function update(string $projectId, array $payload): array {
        return $this->put("/projects/{$projectId}", $payload);
    }

    public function deleteProject(string $projectId): array {
        return $this->delete("/projects/{$projectId}");
    }

    public function addUsers(string $projectId, array $relations): array {
        return $this->post("/projects/{$projectId}/users", ['relations' => $relations]);
    }

    public function changeUserRole(string $projectId, string $userId, string $role): array {
        return $this->patch("/projects/{$projectId}/users/{$userId}", ['role' => $role]);
    }

    public function removeUser(string $projectId, string $userId): array {
        return $this->delete("/projects/{$projectId}/users/{$userId}");
    }
}