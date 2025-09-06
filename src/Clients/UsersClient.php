<?php

namespace Usman\N8n\Clients;

use Usman\N8n\BaseClient;
use Usman\N8n\Entities\User\User;
use Usman\N8n\Entities\User\UserCreateResult;
use Usman\N8n\Entities\User\UserList;

class UsersClient extends BaseClient {
    /**
     * List all users
     *
     * Supported filters:
     * - limit (int)
     * - cursor (string)
     * - includeRole (bool)
     * - projectId (string)
     *
     * @param array $filters
     * @return UserList
     */
    public function listUsers(array $filters = []): UserList {
        $filters['includeRole'] = true; // TODO: Properly manage default values, or the parameters should be arguments rather than array.
        $response = $this->get('/users', $filters);
        return new UserList($response);
    }

    /**
     * Create new users
     *
     * Expects an array of user payloads:
     * [
     *   ['email' => '...', 'firstName' => '...', 'lastName' => '...'],
     *   ...
     * ]
     *
     * @param array $userPayloads
     * @return UserCreateResult[] Created users
     */
    public function createUser(array $userPayloads): array {
        $response = $this->post('/users', $userPayloads);
        return array_map(fn($item) => new UserCreateResult($item), $response);
    }

    /**
     * Get a user by ID or email
     *
     * @param string $idOrEmail
     * @param bool $includeRole
     * @return User
     */
    public function getUser(string $idOrEmail, bool $includeRole = false): User {
        $response = $this->get("/users/{$idOrEmail}", ['includeRole' => $includeRole]);
        return new User($response);
    }

    /**
     * Delete a user by ID or email
     *
     * @param string $idOrEmail
     * @return User Deleted user entity
     */
    public function deleteUser(string $idOrEmail): bool {
        $this->delete("/users/{$idOrEmail}");
        return true;
    }

    /**
     * Change user role
     *
     * @param string $idOrEmail
     * @param string $newRoleName
     * @return User Updated user entity
     */
    public function changeUserRole(string $idOrEmail, string $newRoleName): User {
        $response = $this->patch("/users/{$idOrEmail}/role", ['newRoleName' => $newRoleName]);
        return new User($response);
    }
}
