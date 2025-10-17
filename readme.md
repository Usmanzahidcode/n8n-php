<p align="center">
  <img src="assets/media/n8n_logo.png" alt="n8n-php" width="300">
</p>

<div align="center">

[![Latest Stable Version](https://img.shields.io/packagist/v/usmanzahid/n8n-php.svg)](https://packagist.org/packages/usmanzahid/n8n-php)
[![Total Downloads](https://img.shields.io/packagist/dt/usmanzahid/n8n-php.svg)](https://packagist.org/packages/usmanzahid/n8n-php)
[![PHP Version](https://img.shields.io/packagist/php-v/usmanzahid/n8n-php.svg)](https://www.php.net/)
[![License](https://img.shields.io/packagist/l/usmanzahid/n8n-php.svg)](https://opensource.org/licenses/MIT)

</div>

# n8n-php

A lightweight PHP SDK for [n8n](https://n8n.io), the open-source workflow automation tool. Control your n8n instance directly from PHP: manage workflows, trigger webhooks, handle users, and more.

---

## Quick Start

Install via Composer:

```bash
composer require usmanzahid/n8n-php
```

Connect and start using:

```php
use UsmanZahid\N8n\N8nClient;

N8nClient::connect(
    'https://your-n8n-instance.com',
    'your-api-key'
);

// Get all users
$response = N8nClient::users()->listUsers();

if ($response->success) {
    foreach ($response->data->items as $user) {
        echo $user->email . PHP_EOL;
    }
}
```

That's it. You're ready to go.

---

## Table of Contents

- [Installation](#installation)
- [Configuration](#configuration)
- [Understanding Responses](#understanding-responses)
- [Working with Workflows](#working-with-workflows)
- [Working with Webhooks](#working-with-webhooks)
- [Working with Users](#working-with-users)
- [Working with Tags](#working-with-tags)
- [Working with Variables](#working-with-variables)
- [Working with Projects](#working-with-projects)
- [Working with Executions](#working-with-executions)
- [Working with Credentials](#working-with-credentials)
- [Working with Audit](#working-with-audit)
- [Pagination](#pagination)
- [Contributing](#contributing)
- [License](#license)

---

## Installation

```bash
composer require usmanzahid/n8n-php
```

Requires PHP 7.4 or higher.

---

## Configuration

Before making any requests, connect to your n8n instance:

```php
use UsmanZahid\N8n\N8nClient;

N8nClient::connect(
    'https://your-n8n-instance.com',  // Your n8n instance URL
    'your-api-key'                     // Your n8n API key
);
```

**Optional webhook authentication:**

```php
N8nClient::connect(
    'https://your-n8n-instance.com',
    'your-api-key',
    'webhook-username',  // Optional
    'webhook-password'   // Optional
);
```

---

## Understanding Responses

Every method returns an `N8nResponse` object with these properties:

```php
$response->success;    // bool: true if successful, false otherwise
$response->data;       // object: The actual data returned (workflows, users, etc.)
$response->message;    // string: Error message if something went wrong
$response->statusCode; // int: HTTP status code
```

**Always check for success:**

```php
$response = N8nClient::workflows()->getWorkflow('workflow-id');

if ($response->success) {
    $workflow = $response->data;
    // Use the workflow
} else {
    echo "Error: " . $response->message;
}
```

No exceptions are thrown. Everything is handled through the response object.

---

## Working with Workflows

### List workflows

```php
// Get first page (default: 20 workflows)
$response = N8nClient::workflows()->listWorkflows();

// Get with custom limit
$response = N8nClient::workflows()->listWorkflows(['limit' => 50]);
```

### Get all workflows (handles pagination automatically)

```php
$response = N8nClient::workflows()->listWorkflowsAll();

if ($response->success) {
    foreach ($response->data->items as $workflow) {
        echo $workflow->name . PHP_EOL;
    }
}
```

### Get a single workflow

```php
$response = N8nClient::workflows()->getWorkflow('workflow-id');
```

### Create a workflow

```php
$response = N8nClient::workflows()->createWorkflow([
    'name' => 'My New Workflow',
    'nodes' => [],
    'connections' => []
]);
```

### Update a workflow

```php
$response = N8nClient::workflows()->updateWorkflow('workflow-id', [
    'name' => 'Updated Workflow Name'
]);
```

### Delete a workflow

```php
$response = N8nClient::workflows()->deleteWorkflow('workflow-id');
```

### Activate or deactivate

```php
N8nClient::workflows()->activateWorkflow('workflow-id');
N8nClient::workflows()->deactivateWorkflow('workflow-id');
```

### Transfer to another project

```php
N8nClient::workflows()->transferWorkflow('workflow-id', 'destination-project-id');
```

### Manage workflow tags

```php
// Get tags
$response = N8nClient::workflows()->getTags('workflow-id');

// Update tags (provide array of tag IDs)
N8nClient::workflows()->updateTags('workflow-id', ['tag-id-1', 'tag-id-2']);
```

---

## Working with Webhooks

Trigger webhooks programmatically:

```php
use UsmanZahid\N8n\Enums\WebhookMode;
use UsmanZahid\N8n\Enums\RequestMethod;

$response = N8nClient::webhook(WebhookMode::Production, RequestMethod::Post)
    ->send('your-webhook-id', [
        'key' => 'value',
        'data' => 'your data here'
    ]);

if ($response->success) {
    echo "Webhook triggered successfully!";
}
```

**Webhook modes:**
- `WebhookMode::Production` - Live workflows
- `WebhookMode::Test` - Test mode webhooks

**Request methods:**
- `RequestMethod::Get`
- `RequestMethod::Post`
- `RequestMethod::Put`
- `RequestMethod::Patch`
- `RequestMethod::Delete`

---

## Working with Users

### List users

```php
$response = N8nClient::users()->listUsers();
```

### Get all users

```php
$response = N8nClient::users()->listUsersAll();
```

### Create a user

```php
$response = N8nClient::users()->createUser([
    [
        'email' => 'newuser@example.com',
        'firstName' => 'John',
        'lastName' => 'Doe',
        'role' => 'member'
    ]
]);
```

### Get a user

```php
$response = N8nClient::users()->getUser('user@example.com');
```

### Delete a user

```php
$response = N8nClient::users()->deleteUser('user@example.com');
```

### Change user role

```php
$response = N8nClient::users()->changeUserRole('user@example.com', 'admin');
```

**Available roles:** `member`, `admin`, `owner`

---

## Working with Tags

### List tags

```php
$response = N8nClient::tags()->listTags();
```

### Get all tags

```php
$response = N8nClient::tags()->listTagsAll();
```

### Create a tag

```php
$response = N8nClient::tags()->createTag([
    'name' => 'Production'
]);
```

### Get a tag

```php
$response = N8nClient::tags()->getTag('tag-id');
```

### Update a tag

```php
$response = N8nClient::tags()->updateTag('tag-id', [
    'name' => 'Updated Tag Name'
]);
```

### Delete a tag

```php
$response = N8nClient::tags()->deleteTag('tag-id');
```

---

## Working with Variables

### List variables

```php
$response = N8nClient::variables()->listVariables();
```

### Get all variables

```php
$response = N8nClient::variables()->listVariablesAll();
```

### Create a variable

```php
$response = N8nClient::variables()->createVariable([
    'key' => 'API_KEY',
    'value' => 'secret-value'
]);
```

### Update a variable

```php
$response = N8nClient::variables()->updateVariable('variable-id', [
    'value' => 'new-secret-value'
]);
```

### Delete a variable

```php
$response = N8nClient::variables()->deleteVariable('variable-id');
```

---

## Working with Projects

### List projects

```php
$response = N8nClient::projects()->listProjects();
```

### Get all projects

```php
$response = N8nClient::projects()->listProjectsAll();
```

### Create a project

```php
$response = N8nClient::projects()->createProject([
    'name' => 'My New Project'
]);
```

### Update a project

```php
$response = N8nClient::projects()->updateProject('project-id', [
    'name' => 'Updated Project Name'
]);
```

### Delete a project

```php
$response = N8nClient::projects()->deleteProject('project-id');
```

### Add users to a project

```php
$response = N8nClient::projects()->addUsers('project-id', [
    [
        'userId' => 'user-id-1',
        'role' => 'member'
    ],
    [
        'userId' => 'user-id-2',
        'role' => 'admin'
    ]
]);
```

### Change user role in a project

```php
$response = N8nClient::projects()->changeUserRole('project-id', 'user-id', 'admin');
```

### Remove user from a project

```php
$response = N8nClient::projects()->deleteUser('project-id', 'user-id');
```

---

## Working with Executions

### List executions

```php
// Get first 10 executions
$response = N8nClient::executions()->listExecutions(10);
```

### Get all executions

```php
$response = N8nClient::executions()->listExecutionsAll();
```

### Get a single execution

```php
// Get execution details by ID (basic info only)
$response = N8nClient::executions()->getExecution('execution-id');

// Get execution with full workflow and input/output data
// When $includeData = true, the SDK fetches all execution data from n8n,
// including the workflow structure and the data present when the workflow started.
$includeData = true;
$response = N8nClient::executions()->getExecution('execution-id', $includeData);
```

### Delete an execution

```php
$response = N8nClient::executions()->deleteExecution('execution-id');
```

### Stop a running execution

```php
$response = N8nClient::executions()->stopExecution('execution-id');
```

### Retry a failed execution

```php
$response = N8nClient::executions()->retryExecution('execution-id', [
    'inputData' => []  // Optional custom input data
]);
```

---

## Working with Credentials

### Get credential schema

```php
$response = N8nClient::credentials()->getCredentialSchema('githubApi');
```

### Create a credential

```php
$response = N8nClient::credentials()->createCredential([
    'name' => 'My GitHub Token',
    'type' => 'githubApi',
    'data' => [
        'token' => 'your-github-token'
    ]
]);
```

### Delete a credential

```php
$response = N8nClient::credentials()->deleteCredential('credential-id');
```

---

## Working with Audit

Generate audit logs:

```php
$response = N8nClient::audit()->generateAudit([
    'action' => 'workflow_created',
    'additionalData' => []
]);
```

---

## Pagination

Most list methods support pagination. There are three ways to handle it:

### 1. Manual pagination with limits

```php
$response = N8nClient::workflows()->listWorkflows(['limit' => 10]);
```

### 2. Get all items automatically

```php
$response = N8nClient::workflows()->listWorkflowsAll();
// Fetches all pages automatically
```

### 3. Manual page appending

```php
$response = N8nClient::tags()->listTags();

$tagList = $response->data;
$tagsClient = N8nClient::tags();

// Check if more pages exist
while ($tagsClient->hasMore($tagList)) {
    // Append next page to existing list
    $tagsClient->appendNextTagPage($tagList);
}

// Now $tagList contains all tags from all pages
foreach ($tagList->items as $tag) {
    echo $tag->name . PHP_EOL;
}
```

**Available append methods:**
- `appendNextWorkflowPage()`
- `appendNextUserPage()`
- `appendNextTagPage()`
- `appendNextVariablePage()`
- `appendNextProjectPage()`
- `appendNextExecutionPage()`

---

## Contributing

Contributions are welcome! If you have ideas, find bugs, or want to add features:

1. Fork this repository
2. Create your feature branch
3. Submit a pull request

Every contribution helps make this SDK better for the PHP community.

---

## License

MIT © Usman Zahid

---

## Why This Exists

I needed a clean way to integrate n8n into my PHP projects. Instead of writing the same API calls over and over, I built this SDK to make n8n integration simple and straightforward for PHP developers.

It's feature-complete for core use cases and ready for production. If you find it useful, star the repo and share it with others!