<?php

namespace Usman\N8n\Clients;

use Usman\N8n\BaseClient;

class SourceControlClient extends BaseClient {
    public function pull(array $payload): array {
        return $this->post('/source-control/pull', $payload);
    }
}