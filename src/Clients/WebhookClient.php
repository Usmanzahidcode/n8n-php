<?php

namespace UsmanZahid\N8n\Clients;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use UsmanZahid\N8n\Enums\RequestMethod;
use UsmanZahid\N8n\Enums\WebhookMode;
use UsmanZahid\N8n\Helpers\RequestHelper;
use UsmanZahid\N8n\Response\N8nResponse;

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
     * Send a request to the webhook
     *
     * @param string $webhookId The webhook ID
     * @param array $data Optional payload for the webhook
     * @return N8nResponse<array>
     */
    public function send(string $webhookId, array $data = []): N8nResponse {
        $url = $this->baseUrl . $this->mode->prefix() . "/$webhookId";
        $options = RequestHelper::buildOptions($this->method->value, $data, $this->basicAuth);

        try {
            $response = $this->http->request($this->method->value, $url, $options);
            return $this->buildResponse($response);
        } catch (GuzzleException $e) {
            return RequestHelper::handleException($e);
        }

    }

    /**
     * Handle response and build the N8nResponse
     *
     * @param ResponseInterface $response
     * @return N8nResponse
     */
    protected function buildResponse(ResponseInterface $response): N8nResponse {
        $body = (string) $response->getBody();
        $decoded = $body === '' ? null : (json_decode($body, true) ?? $body);

        $data = is_array($decoded) ? $decoded : $body;
        $message = is_array($decoded) && isset($decoded['message'])
            ? $decoded['message']
            : 'Success';

        return new N8nResponse(true, $data, $message, $response->getStatusCode());
    }
}
