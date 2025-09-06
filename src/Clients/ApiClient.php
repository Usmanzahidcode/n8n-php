<?php

namespace Usman\N8n\Clients;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use Usman\N8n\Response\N8nResponse;

/**
 * Base client for interacting with the N8N API.
 * Returns decoded arrays; no user-facing response handling.
 */
class ApiClient {
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
     * Send a request to the API and return the decoded JSON as an array.
     *
     * @param string $method HTTP method (GET, POST, PUT, PATCH, DELETE)
     * @param string $endpoint API endpoint starting with '/'
     * @param array $data Query parameters or JSON body
     * @return array Decoded JSON response or empty array on failure
     */
    protected function request(string $method, string $endpoint, array $data = []): array {
        $options = $this->buildOptions($method, $data);
        $url = $this->baseUrl . $this->apiPathPrefix . $endpoint;

        try {
            $response = $this->http->request($method, $url, $options);
            $body = (string) $response->getBody();
            $decoded = $body==='' ? null:(json_decode($body, true) ?? $body);

            return [
                'success' => true,
                'data' => $decoded,
                'message' => null,
                'code' => $response->getStatusCode(),
            ];
        } catch (GuzzleException $e) {
            $code = 500;
            $message = $e->getMessage();
            $data = null;

            // If it’s a RequestException, we might have a response body
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

            return [
                'success' => false,
                'data' => $data,
                'message' => $message,
                'code' => $code,
            ];
        }
    }

    /**
     * Build Guzzle request options based on method and data.
     */
    private function buildOptions(string $method, array $data): array {
        $options = [];
        if (strtoupper($method)==='GET' && !empty($data)) {
            $options['query'] = $this->normalizeData($data);
        } elseif (!empty($data)) {
            $options['json'] = $data;
        }
        return $options;
    }

    /**
     * Normalize data for query parameters (remove nulls, convert bools to strings).
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

    // Convenience wrappers for HTTP methods
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

    /**
     * Convert the raw array from BaseClient into a user-facing structure
     * and optionally hydrate an entity class.
     *
     * @param array $raw
     * @param string|null $entityClass
     * @return N8nResponse
     */
    protected function wrapEntity(array $raw, ?string $entityClass = null): N8NResponse {
        $success = $raw['success'] ?? false;

        $data = $success && $entityClass && isset($raw['data'])
            ? new $entityClass($raw['data'])
            :($success ? $raw['data']:null);

        $message = $raw['message'] ?? ($success ? "Success":"Error");

        $code = $raw['code'] ?? ($success ? 200:500);

        return new N8NResponse($success, $data, $message, $code);
    }

}
