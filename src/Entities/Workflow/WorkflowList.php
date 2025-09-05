<?php

namespace Usman\N8n\Entities\Workflow;

use Usman\N8n\Entities\Entity;

class WorkflowList extends Entity {
    /** @var Workflow[] */
    public array $data = [];
    public ?string $nextCursor = null;

    public function __construct(array $payload = []) {
        parent::__construct($payload);

        $this->nextCursor = $payload['nextCursor'] ?? null;

        if (!empty($payload['data']) && is_array($payload['data'])) {
            foreach ($payload['data'] as $workflow) {
                $this->data[] = new Workflow($workflow);
            }
        }
    }

    protected function getFields(): array {
        return [];
    }
}
