<?php

namespace Usman\N8n\Clients;

use Usman\N8n\BaseClient;

class UsersClient extends BaseClient {
    public function listUsers(array $filters = []): array {
        // filters: limit, cursor, includeRole, projectId
        return $this->get('/users', $filters);
    }

    public function createUser(array $userPayloads): array {
        // expects array of user objects
        return $this->post('/users', $userPayloads);
    }

    public function getUser(string $idOrEmail, bool $includeRole = false): array {
        return $this->get("/users/{$idOrEmail}", ['includeRole' => $includeRole]);
    }

    public function deleteUser(string $idOrEmail): array {
        return $this->delete("/users/{$idOrEmail}");
    }

    public function changeUserRole(string $idOrEmail, string $newRoleName): array {
        return $this->patch("/users/{$idOrEmail}/role", ['newRoleName' => $newRoleName]);
    }
}