<?php

namespace Usman\N8n\Clients;

use Usman\N8n\BaseClient;
use Usman\N8n\Entities\Variable\Variable;
use Usman\N8n\Entities\Variable\VariableList;

class VariablesClient extends BaseClient {
    /**
     * Create a variable.
     *
     * @param array $payload Example: ['key' => 'myKey', 'value' => 'myValue']
     * @return Variable
     */
    public function createVariable(array $payload): Variable {
        $response = $this->post('/variables', $payload);
        return new Variable($response);
    }

    /**
     * List variables with pagination support.
     *
     * @param int $limit
     * @param string|null $cursor
     * @return VariableList
     */
    public function listVariables(int $limit = 100, ?string $cursor = null): VariableList {
        $response = $this->get('/variables', array_filter([
            'limit' => $limit,
            'cursor' => $cursor,
        ]));
        return new VariableList($response);
    }

    /**
     * Update a variable by ID.
     *
     * @param string $id
     * @param array $payload
     * @return Variable
     */
    public function updateVariable(string $id, array $payload): Variable {
        $response = $this->put("/variables/{$id}", $payload);
        return new Variable($response);
    }

    /**
     * Delete a variable by ID.
     *
     * @param string $id
     * @return array
     */
    public function deleteVariable(string $id): array {
        return $this->delete("/variables/{$id}");
    }
}
