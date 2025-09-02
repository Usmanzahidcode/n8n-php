<?php

namespace Usman\N8n\Clients;

use Usman\N8n\BaseClient;

class AuditClient extends BaseClient {
    public function generateAudit(array $additionalOptions = []): array {
        return $this->post('/audit', ['additionalOptions' => $additionalOptions]);
    }
}