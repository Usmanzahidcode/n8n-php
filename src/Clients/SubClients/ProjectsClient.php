<?php

namespace Usman\N8n\Clients\SubClients;

use Usman\N8n\Clients\ApiClient;
use Usman\N8n\Entities\Project\Project;
use Usman\N8n\Entities\Project\ProjectList;
use Usman\N8n\Entities\Project\ProjectUserRelation;
use Usman\N8n\Response\N8NResponse;

class ProjectsClient extends ApiClient {
    /**
     * Create a new project.
     *
     * @param array{name: string} $payload Example: ['name' => 'My Project']
     * @return N8NResponse The created project entity
     *
     * API endpoint: POST /projects
     */
    public function createProject(array $payload): N8NResponse {
        $response = $this->post('/projects', $payload);
        return $this->wrapEntity($response, Project::class);
    }

    /**
     * Retrieve a list of projects.
     *
     * @param int $limit Maximum number of projects to return (default 100)
     * @param string|null $cursor Pagination cursor for next page
     * @return N8NResponse Paginated list of project entities
     *
     * API endpoint: GET /projects
     */
    public function listProjects(int $limit = 100, ?string $cursor = null): N8NResponse {
        $response = $this->get('/projects', array_filter([
            'limit' => $limit,
            'cursor' => $cursor,
        ]));
        return $this->wrapEntity($response, ProjectList::class);
    }

    /**
     * Update a project.
     *
     * @param string $projectId The ID of the project
     * @param array{name: string} $payload Example: ['name' => 'Updated Project']
     * @return N8NResponse The updated project entity
     *
     * API endpoint: PUT /projects/{projectId}
     */
    public function updateProject(string $projectId, array $payload): N8NResponse {
        $response = $this->put("/projects/{$projectId}", $payload);
        return $this->wrapEntity($response, Project::class);
    }

    /**
     * Delete a project.
     *
     * @param string $projectId The ID of the project
     * @return N8NResponse The deleted project entity
     *
     * API endpoint: DELETE /projects/{projectId}
     */
    public function deleteProject(string $projectId): N8NResponse {
        $response = $this->delete("/projects/{$projectId}");
        return $this->wrapEntity($response, Project::class);
    }

    /**
     * Add one or more users to a project.
     *
     * @param string $projectId The ID of the project
     * @param array<array{userId: string, role: string}> $relations Array of user relations
     * @return N8NResponse List of created user-project relations
     *
     * API endpoint: POST /projects/{projectId}/users
     */
    public function addUsers(string $projectId, array $relations): N8NResponse {
        $response = $this->post("/projects/{$projectId}/users", ['relations' => $relations]);
        return $this->wrapEntity($response, ProjectUserRelation::class);
    }

    /**
     * Delete a user from a project.
     *
     * @param string $projectId The ID of the project
     * @param string $userId The ID of the user to remove
     * @return N8NResponse The deleted relation entity
     *
     * API endpoint: DELETE /projects/{projectId}/users/{userId}
     */
    public function deleteUser(string $projectId, string $userId): N8NResponse {
        $response = $this->delete("/projects/{$projectId}/users/{$userId}");
        return $this->wrapEntity($response, ProjectUserRelation::class);
    }

    /**
     * Change a user's role in a project.
     *
     * @param string $projectId The ID of the project
     * @param string $userId The ID of the user
     * @param string $role The new role to assign
     * @return N8NResponse The updated relation entity
     *
     * API endpoint: PATCH /projects/{projectId}/users/{userId}
     */
    public function changeUserRole(string $projectId, string $userId, string $role): N8NResponse {
        $response = $this->patch("/projects/{$projectId}/users/{$userId}", ['role' => $role]);
        return $this->wrapEntity($response, ProjectUserRelation::class);
    }
}
