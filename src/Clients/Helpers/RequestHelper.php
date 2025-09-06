<?php

namespace Usman\N8n\Clients\Helpers;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use Usman\N8n\Response\N8nResponse;

/**
 * Utility methods for preparing HTTP request options and handling responses.
 */
class RequestHelper {

    /**
     * Build Guzzle request options.
     *
     * Adds authentication if provided.
     * Uses query parameters for GET requests and JSON body for others.
     *
     * @param string $method HTTP method name
     * @param array $data Query or body data
     * @param array|null $basicAuth Optional ['username' => string, 'password' => string]
     * @return array             Options array suitable for Guzzle client
     */
    public static function buildOptions(string $method, array $data = [], ?array $basicAuth = null): array {
        $options = [];

        if ($basicAuth) {
            $options['auth'] = [$basicAuth['username'], $basicAuth['password']];
        }

        if (strtoupper($method)==='GET' && !empty($data)) {
            $options['query'] = self::normalizeData($data);
        } elseif (!empty($data)) {
            $options['json'] = $data;
        }

        return $options;
    }

    /**
     * Normalize request data for transmission.
     *
     * Removes null values and converts booleans to string.
     * Recursively processes nested arrays.
     *
     * @param array $data
     * @return array
     */
    public static function normalizeData(array $data): array {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $data[$key] = self::normalizeData($value);
            } elseif ($value===null) {
                unset($data[$key]);
            } elseif (is_bool($value)) {
                $data[$key] = $value ? 'true':'false';
            }
        }
        return $data;
    }

    /**
     * Standardized exception handling for HTTP requests.
     *
     * Extracts code, message, and optional response body from Guzzle exceptions.
     * Returns either an N8nResponse object or a raw array.
     *
     * @param GuzzleException $e
     * @param bool $returnArray Return array instead of N8nResponse if true
     * @return N8nResponse|array
     */
    public static function handleException(GuzzleException $e, bool $returnArray = false): N8nResponse|array {
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

        return $returnArray
            ? new N8NResponse(false, $data, $message, $code)
            :[
                'code' => $code,
                'message' => $message,
                'data' => $data,
                'success' => false,
            ];
    }
}
