<?php

namespace Usman\N8n;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use RuntimeException;

class BaseClient {
    protected string $baseUrl;
    protected string $apiPathPrefix = '/api/v1';
    protected string $apiKey;
    protected Client $http;

    public function __construct(string $baseUrl, string $apiKey) {
        $this->baseUrl = rtrim($baseUrl, '/');
        $this->apiKey = $apiKey;

        $this->http = new Client([
            'headers' => [
                'X-N8N-API-KEY' => $this->apiKey,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    /**
     * Send a request to the API.
     *
     * @param string $method HTTP method (GET, POST, PUT, PATCH, DELETE).
     * @param string $endpoint Must start with '/'.
     * @param array $data Query or JSON payload.
     *
     * @return array Decoded JSON response.
     * @throws GuzzleException
     */
    protected function request(string $method, string $endpoint, array $data = []): array {
        $options = $this->buildOptions($method, $data);
        $url = $this->baseUrl . $this->apiPathPrefix . $endpoint;

        try {
            $response = $this->http->request($method, $url, $options);
            $body = (string) $response->getBody();

            return $body==='' ? []:(json_decode($body, true) ?? []);
        } catch (RequestException $e) {
            $message = $e->getMessage();
            if ($e->hasResponse()) {
                $body = $e->getResponse()->getBody()->getContents();
                $message = $body ?:$message;
            }
            throw new RuntimeException($message, $e->getCode(), $e);
        }
    }

    /**
     * Build Guzzle request options based on method and data.
     */
    private function buildOptions(string $method, array $data): array {
        $options = [];

        if (strtoupper($method)==='GET') {
            $query = $this->normalizeData($data);
            if (!empty($query)) {
                $options['query'] = $query;
            }
        } elseif (!empty($data)) {
            $options['json'] = $data;
        }

        return $options;
    }

    /**
     * Normalize data for query parameters.
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

    // Convenience wrappers
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
