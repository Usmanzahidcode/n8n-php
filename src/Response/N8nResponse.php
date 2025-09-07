<?php

namespace UsmanZahid\N8n\Response;

/**
 * @template T
 */
class N8nResponse {
    /** @var bool */
    public bool $success;

    /** @var T|null */
    public mixed $data = null;

    /** @var string */
    public string $message;

    /** @var int */
    public int $statusCode;

    /**
     * @param bool $success
     * @param T|null $data
     * @param string $message
     * @param int $statusCode
     */
    public function __construct(bool $success, mixed $data, string $message, int $statusCode) {
        $this->success = $success;
        $this->data = $data;
        $this->message = $message;
        $this->statusCode = $statusCode;
    }
}