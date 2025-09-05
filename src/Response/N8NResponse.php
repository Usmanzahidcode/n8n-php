<?php

namespace Usman\N8n\Response;

class N8NResponse {
    public bool $success;
    public ?string $message;
    public $data; // Entity, array of entities, or null

    public function __construct(bool $success, $data = null, ?string $message = null) {
        $this->success = $success;
        $this->data = $data;
        $this->message = $message;
    }
}
