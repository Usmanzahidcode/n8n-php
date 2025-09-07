<?php

namespace Usman\N8n\Clients\SubClients;

use Usman\N8n\Clients\ApiClient;
use Usman\N8n\Entities\Audit\Audit;
use Usman\N8n\Response\N8nResponse;

class AuditClient extends ApiClient {
    /**
     * Generate an audit record.
     *
     * API: POST /audit
     *
     * @param array<string,mixed> $additionalOptions Optional parameters to include in the audit generation
     * @return N8nResponse<Audit> The created Audit entity
     */
    public function generateAudit(array $additionalOptions = []): N8nResponse {
        $response = $this->post('/audit', ['additionalOptions' => $additionalOptions]);
        return $this->wrapEntity($response, Audit::class);
    }
}
