<?php

namespace UsmanZahid\N8n\Clients\SubClients;

use UsmanZahid\N8n\Clients\ApiClient;
use UsmanZahid\N8n\Entities\Execution\Execution;
use UsmanZahid\N8n\Entities\Execution\ExecutionList;
use UsmanZahid\N8n\Response\N8nResponse;
use UsmanZahid\N8n\Traits\PaginationTrait;

class ExecutionsClient extends ApiClient {
    use PaginationTrait;

    /**
     * List executions with optional filters.
     *
     * Supported filters:
     * - includeData (bool)
     * - status (canceled|error|success|waiting)
     * - workflowId (string)
     * - projectId (string)
     * - limit (int, max 250, default 100)
     * - cursor (string)
     *
     * @param array{
     *     includeData?: bool,
     *     status?: string,
     *     workflowId?: string,
     *     projectId?: string,
     *     limit?: int,
     *     cursor?: string
     * } $filters
     * @return N8nResponse<ExecutionList> Paginated list of executions
     *
     * API endpoint: GET /executions
     */
    public function listExecutions(array $filters = []): N8nResponse {
        $response = $this->get('/executions', $filters);
        return $this->wrapEntity($response, ExecutionList::class);
    }

    /**
     * Fetch all executions across all pages.
     *
     * @param array $filters Filters to apply (same as listExecutions)
     * @param int $limit Number of items per page (default 100, max 250)
     * @return N8nResponse<ExecutionList> ExecutionList containing all executions
     */
    public function listExecutionsAll(array $filters = [], int $limit = 100): N8nResponse {
        return $this->listAll(
            fn($limit, $cursor) => $this->listExecutions(array_merge($filters, [
                'limit' => $limit,
                'cursor' => $cursor,
            ])),
            $limit
        );
    }

    /**
     * Append the next page of executions to an existing ExecutionList.
     *
     * @param ExecutionList $list The existing ExecutionList
     * @param array $filters Filters to apply
     * @param int $limit Number of items per page (default 100, max 250)
     * @return N8nResponse<ExecutionList> Updated ExecutionList with next page appended
     */
    public function appendNextExecutionPage(ExecutionList $list, array $filters = [], int $limit = 100): N8nResponse {
        return $this->appendNextPage(
            $list,
            fn($l, $c) => $this->listExecutions(array_merge($filters, [
                'limit' => $l,
                'cursor' => $c,
            ])),
            $limit
        );
    }

    /**
     * Get a single execution by ID.
     *
     * @param string $id Execution ID
     * @param bool $includeData Whether to include detailed execution data
     * @return N8nResponse<Execution> The requested Execution
     *
     * API endpoint: GET /executions/{id}
     */
    public function getExecution(string $id, bool $includeData = false): N8nResponse {
        $response = $this->get("/executions/{$id}", ['includeData' => $includeData]);
        return $this->wrapEntity($response, Execution::class);
    }

    /**
     * Delete an execution by ID.
     *
     * @param string $id Execution ID
     * @return N8nResponse<Execution> The deleted Execution
     *
     * API endpoint: DELETE /executions/{id}
     */
    public function deleteExecution(string $id): N8nResponse {
        $response = $this->delete("/executions/{$id}");
        return $this->wrapEntity($response, Execution::class);
    }

    /**
     * Stop a running execution.
     *
     * @param string $id Execution ID
     * @return N8nResponse<Execution> The stopped Execution
     *
     * API endpoint: POST /executions/{id}/stop
     */
    public function stopExecution(string $id): N8nResponse {
        $response = $this->post("/executions/{$id}/stop");
        return $this->wrapEntity($response, Execution::class);
    }

    /**
     * Retry a failed execution.
     *
     * @param string $id Execution ID
     * @param array<string,mixed> $loadData Optional data for retry (input overrides)
     * @return N8nResponse<Execution> The retried Execution
     *
     * API endpoint: POST /executions/{id}/retry
     */
    public function retryExecution(string $id, array $loadData = []): N8nResponse {
        $response = $this->post("/executions/{$id}/retry", $loadData);
        return $this->wrapEntity($response, Execution::class);
    }
}
