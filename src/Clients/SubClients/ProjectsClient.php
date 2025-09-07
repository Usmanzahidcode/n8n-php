<?php

namespace Usman\N8n\Clients\SubClients;

use Usman\N8n\Clients\ApiClient;
use Usman\N8n\Entities\Project\Project;
use Usman\N8n\Entities\Project\ProjectList;
use Usman\N8n\Entities\Project\ProjectUserRelation;
use Usman\N8n\Response\N8nResponse;
use Usman\N8n\Traits\PaginationTrait;

class ProjectsClient extends ApiClient {
    use PaginationTrait;

    /**
     * Create a new project.
     *
     * @param array{name: string} $payload Example: ['name' => 'My Project']
     * @return N8nResponse<Project> The created Project entity
     *
     * API endpoint: POST /projects
     */
    public function createProject(array $payload): N8nResponse {
        $response = $this->post('/projects', $payload);
        return $this->wrapEntity($response, Project::class);
    }

    /**
     * Retrieve a list of projects with pagination.
     *
     * @param int $limit Maximum number of projects to return (default 100)
     * @param string|null $cursor Pagination cursor for next page
     * @return N8nResponse<ProjectList> Paginated list of Project entities
     *
     * API endpoint: GET /projects
     */
    public function listProjects(int $limit = 100, ?string $cursor = null): N8nResponse {
        $response = $this->get('/projects', array_filter([
            'limit' => $limit,
            'cursor' => $cursor,
        ]));
        return $this->wrapEntity($response, ProjectList::class);
    }

    /**
     * Fetch all projects across all pages.
     *
     * @param int $limit Number of items per page (default 100)
     * @return N8nResponse<ProjectList> ProjectList containing all projects
     */
    public function listProjectsAll(int $limit = 100): N8nResponse {
        return $this->listAll(
            fn($limit, $cursor) => $this->listProjects($limit, $cursor),
            $limit
        );
    }

    /**
     * Append the next page of projects to an existing ProjectList.
     *
     * @param ProjectList $list The existing ProjectList
     * @param int $limit Number of items per page (default 100)
     * @return N8nResponse<ProjectList> Updated ProjectList with the next page appended
     */
    public function appendNextProjectPage(ProjectList $list, int $limit = 100): N8nResponse {
        return $this->appendNextPage(
            $list,
            fn($l, $c) => $this->listProjects($l, $c),
            $limit
        );
    }

    /**
     * Update a project.
     *
     * @param string $projectId The ID of the project
     * @param array{name: string} $payload Example: ['name' => 'Updated Project']
     * @return N8nResponse<Project> The updated Project entity
     *
     * API endpoint: PUT /projects/{projectId}
     */
    public function updateProject(string $projectId, array $payload): N8nResponse {
        $response = $this->put("/projects/{$projectId}", $payload);
        return $this->wrapEntity($response, Project::class);
    }

    /**
     * Delete a project.
     *
     * @param string $projectId The ID of the project
     * @return N8nResponse<Project> The deleted Project entity
     *
     * API endpoint: DELETE /projects/{projectId}
     */
    public function deleteProject(string $projectId): N8nResponse {
        $response = $this->delete("/projects/{$projectId}");
        return $this->wrapEntity($response, Project::class);
    }

    /**
     * Add one or more users to a project.
     *
     * @param string $projectId The ID of the project
     * @param array<int, array{userId: string, role: string}> $relations Array of user relations
     * @return N8nResponse<ProjectUserRelation> The created ProjectUserRelation entity
     *
     * API endpoint: POST /projects/{projectId}/users
     */
    public function addUsers(string $projectId, array $relations): N8nResponse {
        $response = $this->post("/projects/{$projectId}/users", ['relations' => $relations]);
        return $this->wrapEntity($response, ProjectUserRelation::class);
    }

    /**
     * Delete a user from a project.
     *
     * @param string $projectId The ID of the project
     * @param string $userId The ID of the user to remove
     * @return N8nResponse<ProjectUserRelation> The deleted ProjectUserRelation entity
     *
     * API endpoint: DELETE /projects/{projectId}/users/{userId}
     */
    public function deleteUser(string $projectId, string $userId): N8nResponse {
        $response = $this->delete("/projects/{$projectId}/users/{$userId}");
        return $this->wrapEntity($response, ProjectUserRelation::class);
    }

    /**
     * Change a user's role in a project.
     *
     * @param string $projectId The ID of the project
     * @param string $userId The ID of the user
     * @param string $role The new role to assign
     * @return N8nResponse<ProjectUserRelation> The updated ProjectUserRelation entity
     *
     * API endpoint: PATCH /projects/{projectId}/users/{userId}
     */
    public function changeUserRole(string $projectId, string $userId, string $role): N8nResponse {
        $response = $this->patch("/projects/{$projectId}/users/{$userId}", ['role' => $role]);
        return $this->wrapEntity($response, ProjectUserRelation::class);
    }
}
