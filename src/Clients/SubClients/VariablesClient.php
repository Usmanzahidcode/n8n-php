<?php

namespace Usman\N8n\Clients\SubClients;

use Usman\N8n\Clients\ApiClient;
use Usman\N8n\Entities\Variable\Variable;
use Usman\N8n\Entities\Variable\VariableList;
use Usman\N8n\Response\N8NResponse;

class VariablesClient extends ApiClient {
    /**
     * Create a variable.
     *
     * @param array $payload Example: ['key' => 'myKey', 'value' => 'myValue']
     * @return N8NResponse The created variable entity
     */
    public function createVariable(array $payload): N8NResponse {
        $response = $this->post('/variables', $payload);
        return $this->wrapEntity($response, Variable::class);
    }

    /**
     * List variables with pagination support.
     *
     * @param int $limit
     * @param string|null $cursor
     * @return N8NResponse Paginated list of variable entities
     */
    public function listVariables(int $limit = 100, ?string $cursor = null): N8NResponse {
        $response = $this->get('/variables', array_filter([
            'limit' => $limit,
            'cursor' => $cursor,
        ]));
        return $this->wrapEntity($response, VariableList::class);
    }

    /**
     * Update a variable by ID.
     *
     * @param string $id
     * @param array $payload
     * @return N8NResponse The updated variable entity
     */
    public function updateVariable(string $id, array $payload): N8NResponse {
        $response = $this->put("/variables/{$id}", $payload);
        return $this->wrapEntity($response, Variable::class);
    }

    /**
     * Delete a variable by ID.
     *
     * @param string $id
     * @return N8NResponse The deleted variable entity or raw response
     */
    public function deleteVariable(string $id): N8NResponse {
        $response = $this->delete("/variables/{$id}");
        return $this->wrapEntity($response, Variable::class);
    }
}
