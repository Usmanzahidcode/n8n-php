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
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->apiKey
            ]
        ]);
    }

    protected function get(string $endpoint, array $query = []) {
        return $this->request('GET', $endpoint, ['query' => $query]);
    }

    protected function post(string $endpoint, array $data = []) {
        return $this->request('POST', $endpoint, ['json' => $data]);
    }

    protected function put(string $endpoint, array $data = []) {
        return $this->request('PUT', $endpoint, ['json' => $data]);
    }

    protected function delete(string $endpoint) {
        return $this->request('DELETE', $endpoint);
    }

    private function request(string $method, string $endpoint, array $options = []) {
        try {
            $response = $this->http->request($method, $endpoint, $options);
            return json_decode((string) $response->getBody(), true);
        } catch (RequestException $e) {
            throw new \RuntimeException(
                $e->getResponse()
                    ? $e->getResponse()->getBody()->getContents()
                    :$e->getMessage()
            );
        }
    }
}