<?php

namespace Usman\N8n\Clients\Helpers;

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
}