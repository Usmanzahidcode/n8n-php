<?php

namespace Usman\N8n\Clients;

use Usman\N8n\BaseClient;

class WorkflowsClient extends BaseClient {
    public function createWorkflow(array $payload): array {
        return $this->post('/workflows', $payload);
    }

    public function listWorkflows(array $filters = []): array {
        // filters: active, tags, name, projectId, excludePinnedData, limit, cursor
        return $this->get('/workflows', $filters);
    }

    public function getWorkflow(string $id, bool $excludePinnedData = false): array {
        return $this->get("/workflows/{$id}", ['excludePinnedData' => $excludePinnedData]);
    }

    public function updateWorkflow(string $id, array $payload): array {
        return $this->put("/workflows/{$id}", $payload);
    }

    public function deleteWorkflow(string $id): array {
        return $this->delete("/workflows/{$id}");
    }

    public function activateWorkflow(string $id): array {
        return $this->post("/workflows/{$id}/activate");
    }

    public function deactivateWorkflow(string $id): array {
        return $this->post("/workflows/{$id}/deactivate");
    }

    public function transferWorkflow(string $id, string $destinationProjectId): array {
        return $this->put("/workflows/{$id}/transfer", [
            'destinationProjectId' => $destinationProjectId,
        ]);
    }

    public function getTags(string $id): array {
        return $this->get("/workflows/{$id}/tags");
    }

    public function updateTags(string $id, array $tagIds): array {
        return $this->put("/workflows/{$id}/tags", $tagIds);
    }
}