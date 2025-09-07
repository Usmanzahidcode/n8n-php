<?php

namespace UsmanZahid\N8n\Entities\Audit;

use UsmanZahid\N8n\Entities\Entity;

class Audit extends Entity {
    public ?RiskReport $credentialsRiskReport = null;
    public ?RiskReport $databaseRiskReport = null;
    public ?RiskReport $filesystemRiskReport = null;
    public ?RiskReport $instanceRiskReport = null;
    public ?RiskReport $nodesRiskReport = null;

    protected function getFields(): array {
        return [
            'credentialsRiskReport' => ['key' => 'Credentials Risk Report', 'type' => 'object', 'class' => RiskReport::class],
            'databaseRiskReport' => ['key' => 'Database Risk Report', 'type' => 'object', 'class' => RiskReport::class],
            'filesystemRiskReport' => ['key' => 'Filesystem Risk Report', 'type' => 'object', 'class' => RiskReport::class],
            'instanceRiskReport' => ['key' => 'Instance Risk Report', 'type' => 'object', 'class' => RiskReport::class],
            'nodesRiskReport' => ['key' => 'Nodes Risk Report', 'type' => 'object', 'class' => RiskReport::class],
        ];
    }

}
