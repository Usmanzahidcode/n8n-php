<?php

namespace Usman\N8n\Clients\SubClients;

use Usman\N8n\Clients\ApiClient;
use Usman\N8n\Entities\Variable\Variable;
use Usman\N8n\Entities\Variable\VariableList;
use Usman\N8n\Response\N8nResponse;
use Usman\N8n\Traits\PaginationTrait;

class VariablesClient extends ApiClient {
    use PaginationTrait;

    /**
     * Create a variable.
     *
     * @param array{key: string, value: string} $payload The variable payload
     * @return N8nResponse<Variable> The created variable entity
     */
    public function createVariable(array $payload): N8nResponse {
        $response = $this->post('/variables', $payload);
        return $this->wrapEntity($response, Variable::class);
    }

    /**
     * Retrieve paginated variables.
     *
     * @param int $limit Maximum number of items to return (default 100)
     * @param string|null $cursor Pagination cursor for next page
     * @return N8nResponse<VariableList> Paginated list of variables
     */
    public function listVariables(int $limit = 100, ?string $cursor = null): N8nResponse {
        $response = $this->get('/variables', array_filter([
            'limit' => $limit,
            'cursor' => $cursor,
        ]));
        return $this->wrapEntity($response, VariableList::class);
    }

    /**
     * Fetch all variables (across all pages).
     *
     * @param int $limit Number of items per page (default 100)
     * @return N8nResponse<VariableList> VariableList containing all variables
     */
    public function listVariablesAll(int $limit = 100): N8nResponse {
        return $this->listAll(
            fn($limit, $cursor) => $this->listVariables($limit, $cursor),
            $limit
        );
    }

    /**
     * Append the next page of variables to an existing VariableList.
     *
     * @param VariableList $list The existing VariableList to append to
     * @param int $limit Number of items per page (default 100)
     * @return N8nResponse<VariableList> Updated VariableList with the next page of variables appended
     */
    public function appendNextVariablePage(VariableList $list, int $limit = 100): N8nResponse {
        return $this->appendNextPage(
            $list,
            fn($l, $c) => $this->listVariables($l, $c),
            $limit
        );
    }

    /**
     * Update a variable by ID.
     *
     * @param string $id The variable ID
     * @param array{key?: string, value?: string} $payload Fields to update
     * @return N8nResponse<Variable> The updated variable entity
     */
    public function updateVariable(string $id, array $payload): N8nResponse {
        $response = $this->put("/variables/{$id}", $payload);
        return $this->wrapEntity($response, Variable::class);
    }

    /**
     * Delete a variable by ID.
     *
     * @param string $id The variable ID
     * @return N8nResponse<Variable> The deleted variable entity
     */
    public function deleteVariable(string $id): N8nResponse {
        $response = $this->delete("/variables/{$id}");
        return $this->wrapEntity($response, Variable::class);
    }
}
