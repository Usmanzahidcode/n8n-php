<?php

namespace UsmanZahid\N8n\Clients\SubClients;

use UsmanZahid\N8n\Clients\ApiClient;
use UsmanZahid\N8n\Entities\Workflow\Workflow;
use UsmanZahid\N8n\Entities\Workflow\WorkflowList;
use UsmanZahid\N8n\Response\N8nResponse;
use UsmanZahid\N8n\Traits\PaginationTrait;

class WorkflowsClient extends ApiClient {
    use PaginationTrait;

    /**
     * Create a new workflow.
     *
     * @param array $payload Workflow data (name, nodes, etc.)
     * @return N8nResponse<Workflow> The created workflow
     */
    public function createWorkflow(array $payload): N8nResponse {
        $response = $this->post('/workflows', $payload);
        return $this->wrapEntity($response, Workflow::class);
    }

    /**
     * List workflows with optional filters.
     *
     * Supported filters: active, name, tags, projectId, excludePinnedData, limit, cursor.
     *
     * @param array $filters Optional filters for workflow listing
     * @return N8nResponse<WorkflowList> Paginated list of workflows
     */
    public function listWorkflows(array $filters = []): N8nResponse {
        $response = $this->get('/workflows', $filters);
        return $this->wrapEntity($response, WorkflowList::class);
    }

    /**
     * Fetch all workflows (across all pages).
     *
     * @param int $limit Number of items per page (default 100)
     * @return N8nResponse<WorkflowList> All workflows merged into a single list
     */
    public function listWorkflowsAll(int $limit = 100): N8nResponse {
        return $this->listAll(
            fn($limit, $cursor) => $this->listWorkflows(['limit' => $limit, 'cursor' => $cursor]),
            $limit
        );
    }

    /**
     * Append the next page of workflows to an existing WorkflowList.
     *
     * @param WorkflowList $list The WorkflowList to append to
     * @param int $limit Number of items per page (default 100)
     * @return N8nResponse<WorkflowList> Updated WorkflowList with appended items
     */
    public function appendNextWorkflowPage(WorkflowList $list, int $limit = 100): N8nResponse {
        return $this->appendNextPage(
            $list,
            fn($l, $c) => $this->listWorkflows(['limit' => $l, 'cursor' => $c]),
            $limit
        );
    }

    /**
     * Get a workflow by ID.
     *
     * @param string $id Workflow ID
     * @param bool $excludePinnedData Whether to exclude pinned data
     * @return N8nResponse<Workflow> The workflow entity
     */
    public function getWorkflow(string $id, bool $excludePinnedData = false): N8nResponse {
        $response = $this->get("/workflows/{$id}", ['excludePinnedData' => $excludePinnedData]);
        return $this->wrapEntity($response, Workflow::class);
    }

    /**
     * Update an existing workflow.
     *
     * @param string $id Workflow ID
     * @param array $payload Fields to update
     * @return N8nResponse<Workflow> The updated workflow
     */
    public function updateWorkflow(string $id, array $payload): N8nResponse {
        $response = $this->put("/workflows/{$id}", $payload);
        return $this->wrapEntity($response, Workflow::class);
    }

    /**
     * Delete a workflow by ID.
     *
     * @param string $id Workflow ID
     * @return N8nResponse<Workflow> The deleted workflow
     */
    public function deleteWorkflow(string $id): N8nResponse {
        $response = $this->delete("/workflows/{$id}");
        return $this->wrapEntity($response, Workflow::class);
    }

    /**
     * Activate a workflow.
     *
     * @param string $id Workflow ID
     * @return N8nResponse<Workflow> Activated workflow
     */
    public function activateWorkflow(string $id): N8nResponse {
        $response = $this->post("/workflows/{$id}/activate");
        return $this->wrapEntity($response, Workflow::class);
    }

    /**
     * Deactivate a workflow.
     *
     * @param string $id Workflow ID
     * @return N8nResponse<Workflow> Deactivated workflow
     */
    public function deactivateWorkflow(string $id): N8nResponse {
        $response = $this->post("/workflows/{$id}/deactivate");
        return $this->wrapEntity($response, Workflow::class);
    }

    /**
     * Transfer a workflow to another project.
     *
     * @param string $id Workflow ID
     * @param string $destinationProjectId Target project ID
     * @return N8nResponse<Workflow> Transferred workflow
     */
    public function transferWorkflow(string $id, string $destinationProjectId): N8nResponse {
        $response = $this->put("/workflows/{$id}/transfer", [
            'destinationProjectId' => $destinationProjectId,
        ]);
        return $this->wrapEntity($response, Workflow::class);
    }

    /**
     * Get tags of a workflow.
     *
     * @param string $id Workflow ID
     * @return N8nResponse<mixed> List of tags
     */
    public function getTags(string $id): N8nResponse {
        $response = $this->get("/workflows/{$id}/tags");
        return $this->wrapEntity($response);
    }

    /**
     * Update tags of a workflow.
     *
     * @param string $id Workflow ID
     * @param array $tagIds Array of tag IDs
     * @return N8nResponse<mixed> Updated tag assignment
     */
    public function updateTags(string $id, array $tagIds): N8nResponse {
        $payload = array_map(fn($tagId) => ['id' => $tagId], $tagIds);
        $response = $this->put("/workflows/{$id}/tags", $payload);
        return $this->wrapEntity($response);
    }
}
