<?php

namespace Usman\N8n\Clients\Helpers;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use Usman\N8n\Response\N8nResponse;

class RequestHelper {
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

        return $returnArray ?
            new N8NResponse(false, $data, $message, $code)
            :[
                'code' => $code,
                'message' => $message,
                'data' => $data,
                'success' => false
            ];

    }
}