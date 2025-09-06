<?php

namespace Usman\N8n\Clients\SubClients;

use Usman\N8n\Clients\ApiClient;
use Usman\N8n\Entities\User\User;
use Usman\N8n\Entities\User\UserCreateResult;
use Usman\N8n\Entities\User\UserList;
use Usman\N8n\Response\N8NResponse;

class UsersClient extends ApiClient {
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
     * @return N8NResponse List of Users
     */
    public function listUsers(array $filters = []): N8NResponse {
        $filters['includeRole'] = true; // TODO:
        $response = $this->get('/users', $filters);
        return $this->wrapEntity($response, UserList::class);
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
     * @return N8NResponse Created User
     */
    public function createUser(array $userPayloads): N8NResponse {
        $response = $this->post('/users', $userPayloads);
        return $this->wrapEntity($response, UserCreateResult::class);
    }

    /**
     * Get a user by ID or email
     *
     * @param string $idOrEmail
     * @param bool $includeRole
     * @return N8NResponse Retrieved User
     */
    public function getUser(string $idOrEmail, bool $includeRole = false): N8NResponse {
        $response = $this->get("/users/{$idOrEmail}", ['includeRole' => $includeRole]);
        return $this->wrapEntity($response, User::class);
    }

    /**
     * Delete a user by ID or email
     *
     * @param string $idOrEmail
     * @return N8NResponse Deleted User
     */
    public function deleteUser(string $idOrEmail): N8NResponse {
        $response = $this->delete("/users/{$idOrEmail}");
        return $this->wrapEntity($response, User::class);
    }

    /**
     * Change user role
     *
     * @param string $idOrEmail
     * @param string $newRoleName
     * @return N8NResponse Updated User
     */
    public function changeUserRole(string $idOrEmail, string $newRoleName): N8NResponse {
        $response = $this->patch("/users/{$idOrEmail}/role", ['newRoleName' => $newRoleName]);
        return $this->wrapEntity($response, User::class);
    }
}
