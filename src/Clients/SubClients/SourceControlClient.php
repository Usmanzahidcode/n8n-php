<?php

namespace Usman\N8n\Clients\SubClients;

use Usman\N8n\Clients\ApiClient;
use Usman\N8n\Entities\SourceControl\PullResult;
use Usman\N8n\Response\N8nResponse;

class SourceControlClient extends ApiClient {
    /**
     * Pull changes from the connected remote repository.
     *
     * Requires the Source Control feature to be licensed
     * and configured with a connected repository.
     *
     * Example:
     * ```php
     * $client->pull([
     *     'force' => true,
     *     'variables' => [
     *         'foo' => 'bar',
     *     ],
     * ]);
     * ```
     *
     * @param array{
     *     force?: bool,
     *     variables?: array<string,string>
     * } $options Options for the pull operation
     *
     * @return N8nResponse<PullResult> Details of the pulled items
     */
    public function pull(array $options = []): N8nResponse {
        $response = $this->post('/source-control/pull', $options);
        return $this->wrapEntity($response, PullResult::class);
    }
}
