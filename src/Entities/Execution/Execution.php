<?php

namespace UsmanZahid\N8n\Entities\Execution;

use UsmanZahid\N8n\Entities\Entity;

class Execution extends Entity {
    public ?int $id = null;
    public ?array $data = null;
    public ?bool $finished = null;
    public ?string $mode = null;
    public ?int $retryOf = null;
    public ?int $retrySuccessId = null;
    public ?string $startedAt = null;
    public ?string $stoppedAt = null;
    public ?string $workflowId = null;
    public ?string $waitTill = null;
    public ?array $customData = null;
    public ?string $status = null;
    public ?array $workflowData = null;

    protected function getFields(): array {
        return [
            'id' => ['key' => 'id', 'type' => 'int'],
            'data' => ['key' => 'data', 'type' => 'array'],
            'finished' => ['key' => 'finished', 'type' => 'bool'],
            'mode' => ['key' => 'mode', 'type' => 'string'],
            'retryOf' => ['key' => 'retryOf', 'type' => 'int'],
            'retrySuccessId' => ['key' => 'retrySuccessId', 'type' => 'int'],
            'startedAt' => ['key' => 'startedAt', 'type' => 'string'],
            'stoppedAt' => ['key' => 'stoppedAt', 'type' => 'string'],
            'workflowId' => ['key' => 'workflowId', 'type' => 'string'],
            'waitTill' => ['key' => 'waitTill', 'type' => 'string'],
            'customData' => ['key' => 'customData', 'type' => 'array'],
            'status' => ['key' => 'status', 'type' => 'string'],
            'workflowData' => ['key' => 'workflowData', 'type' => 'array'],
        ];
    }
}