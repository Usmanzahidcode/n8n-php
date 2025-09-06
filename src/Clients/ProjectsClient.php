<?php

namespace Usman\N8n\Clients;

use Usman\N8n\BaseClient;
use Usman\N8n\Entities\Project\Project;
use Usman\N8n\Entities\Project\ProjectList;
use Usman\N8n\Entities\Project\ProjectUserRelation;

class ProjectsClient extends BaseClient {
    /**
     * Create a new project.
     *
     * @param array{name: string} $payload Example: ['name' => 'My Project']
     * @return Project The created project entity
     *
     * API endpoint: POST /projects
     */
    public function createProject(array $payload): Project {
        $response = $this->post('/projects', $payload);
        return new Project($response);
    }

    /**
     * Retrieve a list of projects.
     *
     * @param int $limit Maximum number of projects to return (default 100)
     * @param string|null $cursor Pagination cursor for next page
     * @return ProjectList Paginated list of project entities
     *
     * API endpoint: GET /projects
     */
    public function listProjects(int $limit = 100, ?string $cursor = null): ProjectList {
        $response = $this->get('/projects', array_filter([
            'limit' => $limit,
            'cursor' => $cursor,
        ]));
        return new ProjectList($response);
    }

    /**
     * Update a project.
     *
     * @param string $projectId The ID of the project
     * @param array{name: string} $payload Example: ['name' => 'Updated Project']
     * @return Project The updated project entity
     *
     * API endpoint: PUT /projects/{projectId}
     */
    public function updateProject(string $projectId, array $payload): Project {
        $response = $this->put("/projects/{$projectId}", $payload);
        return new Project($response);
    }

    /**
     * Delete a project.
     *
     * @param string $projectId The ID of the project
     * @return Project The deleted project entity
     *
     * API endpoint: DELETE /projects/{projectId}
     */
    public function deleteProject(string $projectId): Project {
        $response = $this->delete("/projects/{$projectId}");
        return new Project($response);
    }

    /**
     * Add one or more users to a project.
     *
     * @param string $projectId The ID of the project
     * @param array<array{userId: string, role: string}> $relations Array of user relations
     * @return ProjectUserRelation[] List of created user-project relations
     *
     * API endpoint: POST /projects/{projectId}/users
     */
    public function addUsers(string $projectId, array $relations): array {
        $response = $this->post("/projects/{$projectId}/users", ['relations' => $relations]);
        return array_map(fn($item) => new ProjectUserRelation($item), $response);
    }

    /**
     * Delete a user from a project.
     *
     * @param string $projectId The ID of the project
     * @param string $userId The ID of the user to remove
     * @return ProjectUserRelation The deleted relation entity
     *
     * API endpoint: DELETE /projects/{projectId}/users/{userId}
     */
    public function deleteUser(string $projectId, string $userId): ProjectUserRelation {
        $response = $this->delete("/projects/{$projectId}/users/{$userId}");
        return new ProjectUserRelation($response);
    }

    /**
     * Change a user's role in a project.
     *
     * @param string $projectId The ID of the project
     * @param string $userId The ID of the user
     * @param string $role The new role to assign
     * @return ProjectUserRelation The updated relation entity
     *
     * API endpoint: PATCH /projects/{projectId}/users/{userId}
     */
    public function changeUserRole(string $projectId, string $userId, string $role): ProjectUserRelation {
        $response = $this->patch("/projects/{$projectId}/users/{$userId}", ['role' => $role]);
        return new ProjectUserRelation($response);
    }
}
