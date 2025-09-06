<?php

namespace Usman\N8n\Response;

class N8nResponse {
    public bool $success = true;
    public ?string $message = null;
    public mixed $data = null;
    public int $code = 200;

    public function __construct(bool $success, $data = null, ?string $message = null, int $code = 200) {
        $this->success = $success;
        $this->data = $data;
        $this->message = $message;
        $this->code = $code;
    }
}
