# n8n-php

This is a PHP SDK for [n8n](https://n8n.io), the open source automation tool.

---

## Why this exists

I was integrating n8n end-to-end in my own projects and felt the need for a PHP SDK.  
That is how **n8n-php** was born.

It is still early, and it needs love from the PHP community to grow.

---

## Call for contributions

We need contributors.  
If you use PHP and you love automation, this package is for you.  
Help make it better so the whole community can enjoy it.

Fork it, open pull requests, share ideas. Every contribution matters.

---

## Usage:

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