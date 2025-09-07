<?php

namespace UsmanZahid\N8n\Clients\SubClients;

use UsmanZahid\N8n\Clients\ApiClient;
use UsmanZahid\N8n\Entities\Credential\Credential;
use UsmanZahid\N8n\Entities\Credential\CredentialSchema;
use UsmanZahid\N8n\Response\N8nResponse;

class CredentialsClient extends ApiClient {
    /**
     * Create a new credential.
     *
     * API endpoint: POST /credentials
     *
     * The fields inside `data` are defined by the credential type’s schema,
     * which can be retrieved using {@see self::getCredentialSchema()}.
     *
     * Example (GitHub):
     * ```php
     * [
     *     'name' => "My GitHub Token",
     *     'type' => "githubApi",
     *     'data' => [
     *         'token' => "your-github-token"
     *     ]
     * ]
     * ```
     *
     * Example (Freshdesk API):
     * ```php
     * [
     *     'name' => "Freshdesk Account",
     *     'type' => "freshdeskApi",
     *     'data' => [
     *         'apiKey' => "freshdesk-api-key",
     *         'domain' => "example.freshdesk.com"
     *     ]
     * ]
     * ```
     *
     * @param array{
     *     name: string,
     *     type: string,
     *     data: array<string,mixed>
     * } $payload
     * @return N8nResponse<Credential> The created Credential
     */
    public function createCredential(array $payload): N8nResponse {
        $response = $this->post('/credentials', $payload);
        return $this->wrapEntity($response, Credential::class);
    }

    /**
     * Delete a credential by ID.
     *
     * API endpoint: DELETE /credentials/{id}
     *
     * @param string $id The credential ID
     * @return N8nResponse<Credential> The deleted Credential
     */
    public function deleteCredential(string $id): N8nResponse {
        $response = $this->delete("/credentials/{$id}");
        return $this->wrapEntity($response, Credential::class);
    }

    /**
     * Retrieve the schema for a credential type.
     *
     * API endpoint: GET /credentials/schema/{credentialTypeName}
     *
     * The schema describes the structure of the `data` field when creating credentials.
     * It includes:
     * - `properties`: keys and their types (e.g. "apiKey", "domain")
     * - `required`: which fields are mandatory
     * - `type`: usually "object"
     * - `additionalProperties`: whether extra fields are allowed
     *
     * Example schema for `freshdeskApi`:
     * ```json
     * {
     *   "additionalProperties": false,
     *   "type": "object",
     *   "properties": {
     *     "apiKey": { "type": "string" },
     *     "domain": { "type": "string" }
     *   },
     *   "required": ["apiKey", "domain"]
     * }
     * ```
     *
     * Use this schema to construct the `data` payload for {@see self::createCredential()}.
     *
     * @param string $credentialTypeName Internal credential type (e.g. "githubApi", "freshdeskApi")
     * @return N8nResponse<CredentialSchema> The credential schema definition
     */
    public function getCredentialSchema(string $credentialTypeName): N8nResponse {
        $response = $this->get("/credentials/schema/{$credentialTypeName}");
        return $this->wrapEntity($response, CredentialSchema::class);
    }
}
