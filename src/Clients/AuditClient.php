<?php

namespace Usman\N8n\Clients;

use Usman\N8n\BaseClient;
use Usman\N8n\Entities\Audit\Audit;

class AuditClient extends BaseClient {
    public function generateAudit(array $additionalOptions = []): Audit {
        $response = $this->post('/audit'); //, ['additionalOptions' => $additionalOptions]
        return new Audit($response);
    }
}
