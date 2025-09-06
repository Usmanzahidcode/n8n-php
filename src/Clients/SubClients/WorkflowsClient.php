<?php

namespace Usman\N8n\Clients\SubClients;

use Usman\N8n\Clients\ApiClient;
use Usman\N8n\Entities\Workflow\Workflow;
use Usman\N8n\Entities\Workflow\WorkflowList;
use Usman\N8n\Response\N8NResponse;

class WorkflowsClient extends ApiClient {

    /**
     * Create a new workflow
     *
     * Required fields in $payload:
     * - name (string): The name of the workflow
     * - nodes (array): List of nodes in the workflow. Each node should include:
     *     - id (string)
     *     - name (string)
     *     - type (string)
     *     - typeVersion (float)
     *     - position (array of int)
     *     - parameters (array)
     *     - credentials (array, optional)
     * Optional workflow fields:
     * - active (bool): Whether the workflow is active
     * - isArchived (bool)
     * - settings (array): Workflow settings like executionOrder, timezone, saveExecutionProgress, etc.
     * - connections (array): Node connection map
     * - tags (array): Array of tag IDs
     * - shared (array): Shared users and project info
     *
     * @param array $payload Workflow data
     * @return N8NResponse The created Workflow entity
     */
    public function createWorkflow(array $payload): N8NResponse {
        $response = $this->post('/workflows', $payload);
        return $this->wrapEntity($response, Workflow::class);
    }

    /**
     * List workflows with optional filters
     *
     * Supported filters:
     * - active (bool)
     * - name (string)
     * - tags (array of tag IDs)
     * - projectId (string)
     * - excludePinnedData (bool)
     * - limit (int)
     * - cursor (string)
     *
     * @param array $filters Optional filters for workflow listing
     * @return N8NResponse List of Workflow entities
     */
    public function listWorkflows(array $filters = []): N8NResponse {
        $response = $this->get('/workflows', $filters);
        return $this->wrapEntity($response, WorkflowList::class);
    }

    /**
     * Get a single workflow by ID
     *
     * @param string $id Workflow ID
     * @param bool $excludePinnedData Whether to exclude pinned data in the response
     * @return N8NResponse The Workflow entity
     */
    public function getWorkflow(string $id, bool $excludePinnedData = false): N8NResponse {
        $response = $this->get("/workflows/{$id}", ['excludePinnedData' => $excludePinnedData]);
        return $this->wrapEntity($response, Workflow::class);
    }

    /**
     * Update an existing workflow
     *
     * Accepts the same fields as createWorkflow. Only include fields you want to update.
     *
     * @param string $id Workflow ID
     * @param array $payload Updated workflow data
     * @return N8NResponse The updated Workflow entity
     */
    public function updateWorkflow(string $id, array $payload): N8NResponse {
        $response = $this->put("/workflows/{$id}", $payload);
        return $this->wrapEntity($response, Workflow::class);
    }

    /**
     * Delete a workflow
     *
     * @param string $id Workflow ID
     * @return N8NResponse The deleted Workflow entity
     */
    public function deleteWorkflow(string $id): N8NResponse {
        $response = $this->delete("/workflows/{$id}");
        return $this->wrapEntity($response, Workflow::class);
    }

    /**
     * Activate a workflow
     *
     * @param string $id Workflow ID
     * @return N8NResponse Activated Workflow entity
     */
    public function activateWorkflow(string $id): N8NResponse {
        $response = $this->post("/workflows/{$id}/activate");
        return $this->wrapEntity($response, Workflow::class);
    }

    /**
     * Deactivate a workflow
     *
     * @param string $id Workflow ID
     * @return N8NResponse Deactivated Workflow entity
     */
    public function deactivateWorkflow(string $id): N8NResponse {
        $response = $this->post("/workflows/{$id}/deactivate");
        return $this->wrapEntity($response, Workflow::class);
    }

    /**
     * Transfer workflow to another project
     *
     * @param string $id Workflow ID
     * @param string $destinationProjectId Project ID to transfer the workflow to
     * @return N8NResponse Transferred Workflow entity
     */
    public function transferWorkflow(string $id, string $destinationProjectId): N8NResponse {
        $response = $this->put("/workflows/{$id}/transfer", [
            'destinationProjectId' => $destinationProjectId,
        ]);
        return $this->wrapEntity($response, Workflow::class);
    }

    /**
     * Get tags of a workflow
     *
     * @param string $id Workflow ID
     * @return N8NResponse List of tags
     */
    public function getTags(string $id): N8NResponse {
        $response = $this->get("/workflows/{$id}/tags");
        return $this->wrapEntity($response);
    }

    /**
     * Update tags of a workflow
     *
     * @param string $id Workflow ID
     * @param array $tagIds Array of tag IDs to set for the workflow
     * @return N8NResponse Raw API response
     */
    public function updateTags(string $id, array $tagIds): N8NResponse {
        $payload = array_map(fn($tagId) => ['id' => $tagId], $tagIds);
        $response = $this->put("/workflows/{$id}/tags", $payload);
        return $this->wrapEntity($response);
    }
}
