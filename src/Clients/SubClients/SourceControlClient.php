<?php

namespace Usman\N8n\Clients\SubClients;

use Usman\N8n\Clients\ApiClient;
use Usman\N8n\Entities\SourceControl\PullResult;
use Usman\N8n\Response\N8NResponse;

class SourceControlClient extends ApiClient {
    /**
     * Pull changes from the connected remote repository.
     *
     * This endpoint requires the Source Control feature to be licensed
     * and configured with a connected repository.
     *
     * Example payload:
     * [
     *     'force' => true,
     *     'variables' => [
     *         'foo' => 'bar'
     *     ]
     * ]
     *
     * @param array $options Pull options
     * - force (bool, optional): Whether to force pull even if there are conflicts.
     * - variables (array<string,string>, optional): Environment variables to use during pull.
     *
     * @return N8NResponse Object containing details of the pulled items
     */
    public function pull(array $options = []): N8NResponse {
        $response = $this->post('/source-control/pull', $options);
        return $this->wrapEntity($response, PullResult::class);
    }
}
