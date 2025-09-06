<?php

namespace Usman\N8n\Clients;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use Usman\N8n\Enums\RequestMethod;
use Usman\N8n\Enums\WebhookMode;
use Usman\N8n\Response\N8NResponse;

class WebhookClient {
    protected string $baseUrl;
    protected Client $http;
    protected RequestMethod $method;
    protected WebhookMode $mode;
    private ?array $basicAuth = null;

    public function __construct(
        string        $baseUrl,
        WebhookMode   $mode = WebhookMode::Production,
        RequestMethod $method = RequestMethod::Post,
        ?string       $username = null,
        ?string       $password = null
    ) {
        $this->baseUrl = rtrim($baseUrl, '/');
        $this->mode = $mode;
        $this->method = $method;

        if ($username && $password) {
            $this->basicAuth = [
                'username' => $username,
                'password' => $password,
            ];
        }

        $this->http = new Client([
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    /**
     * Send a request to the webhook
     *
     * @param string $webhookId The webhook ID
     * @param array $data Optional payload for the webhook
     * @return N8NResponse
     */
    public function send(string $webhookId, array $data = []): N8NResponse {
        $url = $this->baseUrl . $this->mode->prefix() . "/$webhookId";
        $options = [];

        if ($this->basicAuth) {
            $options['auth'] = [$this->basicAuth['username'], $this->basicAuth['password']];
        }

        if (strtoupper($this->method->value)==='GET') {
            if (!empty($data)) $options['query'] = $this->normalizeData($data);
        } else {
            if (!empty($data)) $options['json'] = $data;
        }

        try {
            $response = $this->http->request($this->method->value, $url, $options);
            $body = (string) $response->getBody();
            $decoded = $body==='' ? null:(json_decode($body, true) ?? $body);

            return new N8NResponse(true, $decoded, null, $response->getStatusCode());
        } catch (GuzzleException $e) {
            $code = 500;
            $message = $e->getMessage();
            $data = null;

            if ($e instanceof RequestException && $e->hasResponse()) {
                $code = $e->getResponse()->getStatusCode();
                $body = (string) $e->getResponse()->getBody();
                $decoded = json_decode($body, true);
                if (is_array($decoded)) {
                    $message = $decoded['message'] ?? $message;
                    $data = $decoded;
                } else {
                    $message = $body ?:$message;
                }
            }

            return new N8NResponse(false, $data, $message, $code);
        }
    }

    /**
     * Set basic auth credentials
     *
     * @param string $username
     * @param string $password
     * @return $this
     */
    public function withBasicAuth(string $username, string $password): self {
        $this->basicAuth = ['username' => $username, 'password' => $password];
        return $this;
    }

    /**
     * Remove basic auth credentials
     *
     * @return $this
     */
    public function withoutBasicAuth(): self {
        $this->basicAuth = null;
        return $this;
    }

    /**
     * Normalize data for query parameters (remove nulls, convert bools to strings)
     *
     * @param array $data
     * @return array
     */
    private function normalizeData(array $data): array {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $data[$key] = $this->normalizeData($value);
            } elseif ($value===null) {
                unset($data[$key]);
            } elseif (is_bool($value)) {
                $data[$key] = $value ? 'true':'false';
            }
        }
        return $data;
    }
}
