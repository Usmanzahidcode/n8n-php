<?php

namespace Usman\N8n\Clients\SubClients;

use Usman\N8n\Clients\ApiClient;
use Usman\N8n\Entities\User\User;
use Usman\N8n\Entities\User\UserCreateResult;
use Usman\N8n\Entities\User\UserList;
use Usman\N8n\Response\N8nResponse;
use Usman\N8n\Traits\PaginationTrait;

class UsersClient extends ApiClient {
    use PaginationTrait;

    /**
     * Retrieve paginated users.
     *
     * Supported filters:
     * - limit (int)
     * - cursor (string)
     * - includeRole (bool, defaults to true)
     * - projectId (string)
     *
     * @param int $limit Maximum number of items to return (default 100)
     * @param string|null $cursor Pagination cursor for next page
     * @param array $extraFilters Additional filters to apply
     * @return N8nResponse<UserList> Paginated list of users
     */
    public function listUsers(int $limit = 100, ?string $cursor = null, array $extraFilters = []): N8nResponse {
        $filters = array_merge($extraFilters, [
            'limit' => $limit,
            'cursor' => $cursor,
            'includeRole' => true,
        ]);

        $response = $this->get('/users', array_filter($filters));
        return $this->wrapEntity($response, UserList::class);
    }

    /**
     * Fetch all users (across all pages).
     *
     * @param int $limit Number of items per page (default 100)
     * @param array $extraFilters Additional filters to apply
     * @return N8nResponse<UserList> UserList containing all users
     */
    public function listUsersAll(int $limit = 100, array $extraFilters = []): N8nResponse {
        return $this->listAll(
            fn($limit, $cursor) => $this->listUsers($limit, $cursor, $extraFilters),
            $limit
        );
    }

    /**
     * Append the next page of users to an existing UserList.
     *
     * @param UserList $list The existing UserList to append to
     * @param int $limit Number of items per page (default 100)
     * @param array $extraFilters Additional filters to apply
     * @return N8nResponse<UserList> Updated UserList with the next page of users appended
     */
    public function appendNextUserPage(UserList $list, int $limit = 100, array $extraFilters = []): N8nResponse {
        return $this->appendNextPage(
            $list,
            fn($l, $c) => $this->listUsers($l, $c, $extraFilters),
            $limit
        );
    }

    /**
     * Create new users.
     *
     * Example payload:
     * [
     *   ['email' => '...', 'firstName' => '...', 'lastName' => '...'],
     *   ...
     * ]
     *
     * @param array<int, array{email: string, firstName: string, lastName: string}> $userPayloads
     * @return N8nResponse<UserCreateResult> The result of user creation
     */
    public function createUser(array $userPayloads): N8nResponse {
        $response = $this->post('/users', $userPayloads);
        return $this->wrapEntity($response, UserCreateResult::class);
    }

    /**
     * Get a user by ID or email.
     *
     * @param string $idOrEmail The user ID or email
     * @param bool $includeRole Whether to include role details (default false)
     * @return N8nResponse<User> The retrieved User entity
     */
    public function getUser(string $idOrEmail, bool $includeRole = false): N8nResponse {
        $response = $this->get("/users/{$idOrEmail}", ['includeRole' => $includeRole]);
        return $this->wrapEntity($response, User::class);
    }

    /**
     * Delete a user by ID or email.
     *
     * @param string $idOrEmail The user ID or email
     * @return N8nResponse<User> The deleted User entity
     */
    public function deleteUser(string $idOrEmail): N8nResponse {
        $response = $this->delete("/users/{$idOrEmail}");
        return $this->wrapEntity($response, User::class);
    }

    /**
     * Change a user's role.
     *
     * @param string $idOrEmail The user ID or email
     * @param string $newRoleName The new role name
     * @return N8nResponse<User> The updated User entity
     */
    public function changeUserRole(string $idOrEmail, string $newRoleName): N8nResponse {
        $response = $this->patch("/users/{$idOrEmail}/role", ['newRoleName' => $newRoleName]);
        return $this->wrapEntity($response, User::class);
    }
}
