<?php

namespace Usman\N8n\Clients;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Usman\N8n\Enums\RequestMethod;

class WebhooksClient {
    protected string $baseUrl;
    protected Client $http;
    protected RequestMethod $method;
    private ?array $basicAuth = null;

    public function __construct(string $baseUrl, RequestMethod $method = RequestMethod::Post, ?string $username = null, ?string $password = null) {
        $this->baseUrl = rtrim($baseUrl, '/');
        $this->method = $method;

        if ($username && $password) {
            $this->basicAuth = [
                'username' => $username,
                'password' => $password,
            ];
        }

        $this->http = new Client([
            'base_uri' => $this->baseUrl,
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        ]);
    }

    public function request(string $path, array $data = []): ?array {
        try {
            $options = [];

            if ($this->basicAuth) {
                $options['auth'] = [$this->basicAuth['username'], $this->basicAuth['password']];
            }

            if (strtoupper($this->method->value)==='GET') {
                if (!empty($data)) {
                    $options['query'] = $data;
                }
            } else {
                if (!empty($data)) {
                    $options['json'] = $data;
                }
            }

            $response = $this->http->request($this->method->value, $path, $options);
            $body = (string) $response->getBody();

            return !empty($body) ? json_decode($body, true):null;
        } catch (RequestException $e) {
            $errorMessage = $e->getMessage();
            if ($e->hasResponse()) {
                $errorBody = $e->getResponse()->getBody()->getContents();
                $errorMessage = $errorBody ?:$errorMessage;
            }
            throw new \RuntimeException($errorMessage, $e->getCode(), $e);
        }
    }

    public function withBasicAuth(string $username, string $password): self {
        $this->basicAuth = [
            'username' => $username,
            'password' => $password,
        ];
        return $this;
    }

    public function withoutBasicAuth(): self {
        $this->basicAuth = null;
        return $this;
    }
}