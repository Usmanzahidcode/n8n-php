<?php

namespace Usman\N8n\Clients;

use Usman\N8n\BaseClient;
use Usman\N8n\Entities\SourceControl\PullResult;

class SourceControlClient extends BaseClient {
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
     * @return PullResult Object containing details of the pulled items:
     * - variables: List of added/changed variables.
     * - credentials: Array of credentials with id, name, and type.
     * - workflows: Array of workflows with id and name.
     * - tags: Tag section with tags and workflow-tag mappings.
     */
    public function pull(array $options = []): PullResult {
        $response = $this->post('/source-control/pull', $options);
        return new PullResult($response);
    }
}
