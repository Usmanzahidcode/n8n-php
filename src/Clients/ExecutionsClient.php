<?php

namespace Usman\N8n\Clients;

use Usman\N8n\BaseClient;

class ExecutionsClient extends BaseClient {
    public function listExecutions(array $filters = []): array {
        return $this->get('/executions', $filters);
    }

    public function getExecution(string $id, bool $includeData = false): array {
        return $this->get("/executions/{$id}", ['includeData' => $includeData]);
    }

    public function deleteExecution(string $id): array {
        return $this->delete("/executions/{$id}");
    }

    public function stopExecution(string $id): array {
        return $this->post("/executions/{$id}/stop");
    }

    public function retryExecution(string $id, array $loadData = []): array {
        return $this->post("/executions/{$id}/retry", $loadData);
    }
}