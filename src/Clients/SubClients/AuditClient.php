<?php

namespace Usman\N8n\Clients\SubClients;

use Usman\N8n\Clients\ApiClient;
use Usman\N8n\Entities\Audit\Audit;
use Usman\N8n\Response\N8NResponse;

class AuditClient extends ApiClient {
    /**
     * Generate an audit record.
     *
     * API endpoint: POST /audit
     *
     * @param array $additionalOptions Optional parameters to include in the audit generation
     * @return N8NResponse The created Audit entity
     */
    public function generateAudit(array $additionalOptions = []): N8NResponse {
        $response = $this->post('/audit', ['additionalOptions' => $additionalOptions]);
        return $this->wrapEntity($response, Audit::class);
    }
}
