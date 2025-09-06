<?php

namespace Usman\N8n\Clients;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Usman\N8n\Clients\Helpers\RequestHelper;
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
        $options = RequestHelper::buildOptions($this->method->value, $data, $this->basicAuth);

        try {
            $response = $this->http->request($this->method->value, $url, $options);
            $body = (string) $response->getBody();
            $decoded = $body==='' ? null:(json_decode($body, true) ?? $body);

            return new N8NResponse(true, $decoded, null, $response->getStatusCode());
        } catch (GuzzleException $e) {
            return RequestHelper::handleException($e);
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
}
