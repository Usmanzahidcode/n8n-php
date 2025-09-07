<?php

namespace UsmanZahid\N8n\Entities\Workflow;

use UsmanZahid\N8n\Entities\Entity;

class WorkflowSettings extends Entity {
    public ?string $errorWorkflow = null;
    public ?string $executionOrder = null;
    public ?int $executionTimeout = null;
    public ?string $saveDataErrorExecution = null;
    public ?string $saveDataSuccessExecution = null;
    public ?bool $saveExecutionProgress = null;
    public ?bool $saveManualExecutions = null;
    public ?string $timezone = null;

    protected function getFields(): array {
        return [
            'errorWorkflow' => ['key' => 'errorWorkflow', 'type' => 'string'],
            'executionOrder' => ['key' => 'executionOrder', 'type' => 'string'],
            'executionTimeout' => ['key' => 'executionTimeout', 'type' => 'int'],
            'saveDataErrorExecution' => ['key' => 'saveDataErrorExecution', 'type' => 'string'],
            'saveDataSuccessExecution' => ['key' => 'saveDataSuccessExecution', 'type' => 'string'],
            'saveExecutionProgress' => ['key' => 'saveExecutionProgress', 'type' => 'bool'],
            'saveManualExecutions' => ['key' => 'saveManualExecutions', 'type' => 'bool'],
            'timezone' => ['key' => 'timezone', 'type' => 'string'],
        ];
    }
}
