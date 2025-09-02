<?php

namespace Usman\N8n;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class BaseClient {
    protected string $baseUrl;
    protected string $apiKey;
    protected Client $http;

    public function __construct(string $baseUrl, string $apiKey) {
        $this->baseUrl = rtrim($baseUrl, '/');
        $this->apiKey = $apiKey;

        $this->http = new Client([
            'base_uri' => $this->baseUrl,
            'headers' => [
                'X-N8N-API-KEY' => $this->apiKey,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        ]);
    }

    protected function request(string $method, string $endpoint, array $data = []): array {
        try {
            $options = [];

            if (strtoupper($method)==='GET') {
                $data = $this->prepareQuery($data);
                if (!empty($data)) {
                    $options['query'] = $data;
                }
            } else {
                if (!empty($data)) {
                    $options['json'] = $data;
                }
            }

            $response = $this->http->request($method, $endpoint, $options);
            $body = (string) $response->getBody();

            // Handle empty responses (like 204 No Content)
            if (empty($body)) {
                return [];
            }

            return json_decode($body, true) ?? [];
        } catch (RequestException $e) {
            $errorMessage = $e->getMessage();
            if ($e->hasResponse()) {
                $errorBody = $e->getResponse()->getBody()->getContents();
                $errorMessage = $errorBody ?:$errorMessage;
            }
            throw new \RuntimeException($errorMessage, $e->getCode(), $e);
        }
    }

    private function prepareQuery(array $data): array {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $data[$key] = $this->prepareQuery($value);
            } elseif (is_null($value)) {
                unset($data[$key]);
            } elseif (is_bool($value)) {
                $data[$key] = $value ? 'true':'false';
            }
        }
        return $data;
    }

    protected function get(string $endpoint, array $query = []): array {
        return $this->request('GET', $endpoint, $query);
    }

    protected function post(string $endpoint, array $data = []): array {
        return $this->request('POST', $endpoint, $data);
    }

    protected function put(string $endpoint, array $data = []): array {
        return $this->request('PUT', $endpoint, $data);
    }

    protected function patch(string $endpoint, array $data = []): array {
        return $this->request('PATCH', $endpoint, $data);
    }

    protected function delete(string $endpoint): array {
        return $this->request('DELETE', $endpoint);
    }
}