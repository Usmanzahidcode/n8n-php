<?php

namespace Usman\N8n\Clients\SubClients;

use Usman\N8n\Clients\ApiClient;
use Usman\N8n\Entities\Execution\Execution;
use Usman\N8n\Entities\Execution\ExecutionList;
use Usman\N8n\Response\N8NResponse;

class ExecutionsClient extends ApiClient {

    /**
     * List executions with optional filters
     *
     * Supported filters:
     * - includeData (bool)
     * - status (string: canceled|error|success|waiting)
     * - workflowId (string)
     * - projectId (string)
     * - limit (int, max 250, default 100)
     * - cursor (string)
     *
     * @param array $filters
     * @return N8NResponse Paginated list of execution entities
     */
    public function listExecutions(array $filters = []): N8NResponse {
        $response = $this->get('/executions', $filters);
        return $this->wrapEntity($response, ExecutionList::class);
    }

    /**
     * Get a single execution by ID
     *
     * @param string $id Execution ID
     * @param bool $includeData Whether to include detailed execution data
     * @return N8NResponse The requested execution entity
     */
    public function getExecution(string $id, bool $includeData = false): N8NResponse {
        $response = $this->get("/executions/{$id}", ['includeData' => $includeData]);
        return $this->wrapEntity($response, Execution::class);
    }

    /**
     * Delete an execution by ID
     *
     * @param string $id Execution ID
     * @return N8NResponse The deleted execution entity
     */
    public function deleteExecution(string $id): N8NResponse {
        $response = $this->delete("/executions/{$id}");
        return $this->wrapEntity($response, Execution::class);
    }

    /**
     * Stop a running execution
     *
     * @param string $id Execution ID
     * @return N8NResponse The stopped execution entity
     */
    public function stopExecution(string $id): N8NResponse {
        $response = $this->post("/executions/{$id}/stop");
        return $this->wrapEntity($response, Execution::class);
    }

    /**
     * Retry a failed execution
     *
     * @param string $id Execution ID
     * @param array $loadData Optional data for retry (input overrides)
     * @return N8NResponse The retried execution entity
     */
    public function retryExecution(string $id, array $loadData = []): N8NResponse {
        $response = $this->post("/executions/{$id}/retry", $loadData);
        return $this->wrapEntity($response, Execution::class);
    }
}
