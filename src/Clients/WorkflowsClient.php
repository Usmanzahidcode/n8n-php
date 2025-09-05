<?php

namespace Usman\N8n\Clients;

use Usman\N8n\BaseClient;
use Usman\N8n\Entities\Workflow\Workflow;

class WorkflowsClient extends BaseClient {

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
     * @return Workflow The created Workflow entity
     */
    public function createWorkflow(array $payload): Workflow {
        $response = $this->post('/workflows', $payload);
        return new Workflow($response);
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
     * @return Workflow[] List of Workflow entities
     */
    public function listWorkflows(array $filters = []): array {
        $response = $this->get('/workflows', $filters);
        return array_map(fn($item) => new Workflow($item), $response['data'] ?? []);
    }

    /**
     * Get a single workflow by ID
     *
     * @param string $id Workflow ID
     * @param bool $excludePinnedData Whether to exclude pinned data in the response
     * @return Workflow The Workflow entity
     */
    public function getWorkflow(string $id, bool $excludePinnedData = false): Workflow {
        $response = $this->get("/workflows/{$id}", ['excludePinnedData' => $excludePinnedData]);
        return new Workflow($response);
    }

    /**
     * Update an existing workflow
     *
     * Accepts the same fields as createWorkflow. Only include fields you want to update.
     *
     * @param string $id Workflow ID
     * @param array $payload Updated workflow data
     * @return Workflow The updated Workflow entity
     */
    public function updateWorkflow(string $id, array $payload): Workflow {
        $response = $this->put("/workflows/{$id}", $payload);
        return new Workflow($response);
    }

    /**
     * Delete a workflow
     *
     * @param string $id Workflow ID
     * @return array Raw API response
     */
    public function deleteWorkflow(string $id): Workflow {
        $response = $this->delete("/workflows/{$id}");
        return new Workflow($response);
    }

    /**
     * Activate a workflow
     *
     * @param string $id Workflow ID
     * @return Workflow Activated Workflow entity
     */
    public function activateWorkflow(string $id): Workflow {
        $response = $this->post("/workflows/{$id}/activate");
        return new Workflow($response);
    }

    /**
     * Deactivate a workflow
     *
     * @param string $id Workflow ID
     * @return Workflow Deactivated Workflow entity
     */
    public function deactivateWorkflow(string $id): Workflow {
        $response = $this->post("/workflows/{$id}/deactivate");
        return new Workflow($response);
    }

    /**
     * Transfer workflow to another project
     *
     * @param string $id Workflow ID
     * @param string $destinationProjectId Project ID to transfer the workflow to
     * @return Workflow Transferred Workflow entity
     */
    public function transferWorkflow(string $id, string $destinationProjectId): Workflow {
        $response = $this->put("/workflows/{$id}/transfer", [
            'destinationProjectId' => $destinationProjectId,
        ]);
        return new Workflow($response);
    }

    /**
     * Get tags of a workflow
     *
     * @param string $id Workflow ID
     * @return array List of tags
     */
    public function getTags(string $id): array {
        $response = $this->get("/workflows/{$id}/tags");
        return $response['data'] ?? [];
    }

    /**
     * Update tags of a workflow
     *
     * @param string $id Workflow ID
     * @param array $tagIds Array of tag IDs to set for the workflow
     * @return array Raw API response
     */
    public function updateTags(string $id, array $tagIds): array {
        return $this->put("/workflows/{$id}/tags", $tagIds);
    }
}
