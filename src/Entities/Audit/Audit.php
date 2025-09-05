<?php

namespace Usman\N8n\Entities;

class Audit extends Entity
{
    public ?RiskReport $credentialsRiskReport = null;
    public ?RiskReport $databaseRiskReport = null;
    public ?RiskReport $filesystemRiskReport = null;
    public ?RiskReport $instanceRiskReport = null;
    public ?RiskReport $nodesRiskReport = null;

    protected function getFields(): array
    {
        return [
            'credentialsRiskReport' => RiskReport::class,
            'databaseRiskReport' => RiskReport::class,
            'filesystemRiskReport' => RiskReport::class,
            'instanceRiskReport' => RiskReport::class,
            'nodesRiskReport' => RiskReport::class,
        ];
    }
}
