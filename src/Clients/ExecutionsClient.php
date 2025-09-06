<?php

namespace Usman\N8n\Clients;

use Usman\N8n\BaseClient;
use Usman\N8n\Entities\Execution\Execution;
use Usman\N8n\Entities\Execution\ExecutionList;

class ExecutionsClient extends BaseClient {

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
     * @return ExecutionList
     */
    public function listExecutions(array $filters = []): ExecutionList {
        $response = $this->get('/executions', $filters);
        return new ExecutionList($response);
    }

    /**
     * Get a single execution by ID
     *
     * @param string $id Execution ID
     * @param bool $includeData Whether to include detailed execution data
     * @return Execution
     */
    public function getExecution(string $id, bool $includeData = false): Execution {
        $response = $this->get("/executions/{$id}", ['includeData' => $includeData]);
        return new Execution($response);
    }

    /**
     * Delete an execution by ID
     *
     * @param string $id Execution ID
     * @return Execution The deleted Execution entity
     */
    public function deleteExecution(string $id): Execution {
        $response = $this->delete("/executions/{$id}");
        return new Execution($response);
    }

    /**
     * Stop a running execution
     *
     * @param string $id Execution ID
     * @return Execution The stopped Execution entity
     */
    public function stopExecution(string $id): Execution {
        $response = $this->post("/executions/{$id}/stop");
        return new Execution($response);
    }

    /**
     * Retry a failed execution
     *
     * @param string $id Execution ID
     * @param array $loadData Optional data for retry (input overrides)
     * @return Execution The retried Execution entity
     */
    public function retryExecution(string $id, array $loadData = []): Execution {
        $response = $this->post("/executions/{$id}/retry", $loadData);
        return new Execution($response);
    }
}
