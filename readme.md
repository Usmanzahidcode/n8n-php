# n8n-php

Current understanding:
Auth is done through header of X-N8N-API-KEY

For pagination the cursor is used like this: cursor=cursor_id_039845789uierhgfi9ew86tyh


ANd here is the current structure:
n8n-php-sdk/
│
├── src/
│   ├── BaseClient.php             // Core HTTP handling
│   ├── N8nClient.php              // Static entry point, init & entity clients
│   │
│   ├── Clients/                   // All entity-specific API clients
│   │   ├── TagsClient.php
│   │   ├── WorkflowsClient.php
│   │   ├── ExecutionsClient.php
│   │   └── (more clients later)
│   │
│   ├── Entities/                  // Data models (objects) & collections
│   │   ├── Tag.php
│   │   ├── TagList.php
│   │   ├── Workflow.php
│   │   ├── WorkflowList.php
│   │   └── (more entity objects later)
│   │
│   └── Exceptions/                // Custom exceptions
│       ├── ApiException.php
│       └── AuthenticationException.php
│
├── tests/                         // Unit & integration tests
│
├── composer.json
├── README.md
└── LICENSE
