# n8n-php

### Usage:
```php

N8nClient::connect(
    'https://your-n8n-instance.com/api/v1', 
    'your-api-key',
    'https://your-n8n-instance.com/webhook',
    'webhook-username', 
    'webhook-password' 
);

$workflows = N8nClient::workflows()->list();
$tags = N8nClient::tags()->list();
$users = N8nClient::users()->list();

$result = N8nClient::webhooks(RequestMethod::Post)
    ->request('/your-webhook-path', ['data' => 'value']);

```