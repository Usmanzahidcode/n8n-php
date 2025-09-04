<?php

use Usman\N8n\N8nClient;

class TestTest {
    public function test() {
        N8nClient::connect(
            apiBaseUrl: "",
            apiKey: "",
            webhookBaseUrl: "",
            webhookUsername: "",
            webhookPassword: ""
        );
    }
}