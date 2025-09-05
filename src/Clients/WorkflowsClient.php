<?php

namespace Usman\N8n\Clients;

use Usman\N8n\BaseClient;
use Usman\N8n\Entities\Workflow\Workflow;

class WorkflowsClient extends BaseClient {

    /**
     * Create a new workflow
     */
    public function createWorkflow(array $payload): Workflow {
        $response = $this->post('/workflows', $payload);
        return new Workflow($response);
    }

    /**
     * List workflows with optional filters
     */
    public function listWorkflows(array $filters = []): array {
        $response = $this->get('/workflows', $filters);

        // Map each workflow JSON to a Workflow entity
        return array_map(fn($item) => new Workflow($item), $response['data'] ?? []);
    }

    /**
     * Get a single workflow by ID
     */
    public function getWorkflow(string $id, bool $excludePinnedData = false): Workflow {
        $response = $this->get("/workflows/{$id}", ['excludePinnedData' => $excludePinnedData]);
        return new Workflow($response);
    }

    /**
     * Update an existing workflow
     */
    public function updateWorkflow(string $id, array $payload): Workflow {
        $response = $this->put("/workflows/{$id}", $payload);
        return new Workflow($response);
    }

    /**
     * Delete a workflow
     */
    public function deleteWorkflow(string $id): array {
        return $this->delete("/workflows/{$id}");
    }

    /**
     * Activate a workflow
     */
    public function activateWorkflow(string $id): Workflow {
        $response = $this->post("/workflows/{$id}/activate");
        return new Workflow($response);
    }

    /**
     * Deactivate a workflow
     */
    public function deactivateWorkflow(string $id): Workflow {
        $response = $this->post("/workflows/{$id}/deactivate");
        return new Workflow($response);
    }

    /**
     * Transfer workflow to another project
     */
    public function transferWorkflow(string $id, string $destinationProjectId): Workflow {
        $response = $this->put("/workflows/{$id}/transfer", [
            'destinationProjectId' => $destinationProjectId,
        ]);
        return new Workflow($response);
    }

    /**
     * Get tags of a workflow
     */
    public function getTags(string $id): array {
        $response = $this->get("/workflows/{$id}/tags");
        return $response['data'] ?? [];
    }

    /**
     * Update tags of a workflow
     */
    public function updateTags(string $id, array $tagIds): array {
        return $this->put("/workflows/{$id}/tags", $tagIds);
    }
}
