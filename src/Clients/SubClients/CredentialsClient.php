<?php

namespace Usman\N8n\Clients\SubClients;

use Usman\N8n\Clients\ApiClient;
use Usman\N8n\Entities\Credential\Credential;
use Usman\N8n\Entities\Credential\CredentialSchema;
use Usman\N8n\Response\N8NResponse;

class CredentialsClient extends ApiClient {
    /**
     * Create a new credential.
     *
     * API: POST /credentials
     *
     * The fields inside `data` are defined by the credential type’s schema,
     * which can be retrieved using {@see self::getCredentialSchema()}.
     *
     * Example for GitHub credentials:
     *  [
     *      'name' => "My GitHub Token",
     *      'type' => "github",
     *      'data' => [
     *          'token' => "your-github-token"
     *      ]
     *  ]
     *
     * Example for Freshdesk API credentials:
     *  [
     *      'name' => "Freshdesk Account",
     *      'type' => "freshdeskApi",
     *      'data' => [
     *          'apiKey' => "freshdesk-api-key",
     *          'domain' => "example.freshdesk.com"
     *      ]
     *  ]
     *
     * @param array{
     *     name:string,
     *     type:string,
     *     data:array<string,mixed>
     * } $payload
     *
     * @return N8NResponse Created credential
     */
    public function createCredential(array $payload): N8NResponse {
        $response = $this->post('/credentials', $payload);
        return $this->wrapEntity($response, Credential::class);
    }

    /**
     * Delete a credential by ID.
     *
     * API: DELETE /credentials/{id}
     *
     * @param string $id The credential ID
     * @return N8NResponse Deleted credential)
     */
    public function deleteCredential(string $id): N8NResponse {
        $response = $this->delete("/credentials/{$id}");
        return $this->wrapEntity($response, Credential::class);
    }

    /**
     * Retrieve the schema for a credential type.
     *
     * API: GET /credentials/schema/{credentialTypeName}
     *
     * The schema describes the exact structure of the `data` field when creating credentials.
     * This includes:
     *  - `properties`: the keys and their types (e.g. "apiKey", "token", "domain")
     *  - `required`: which fields must be provided
     *  - `type`: usually "object"
     *  - `additionalProperties`: whether extra fields are allowed
     *
     * Important:
     * There is no global reference list of valid `credentialTypeName` values.
     * They are dynamically defined by n8n and tied to specific nodes.
     * To discover the correct type:
     *  - You should visit: https://community.n8n.io/t/98430
     *  - Inspect the source code of the node in n8n (e.g. Microsoft Outlook uses `microsoftOutlookOAuth2Api`).
     *  - Or experiment with known values such as:
     *      - "n8nApi"
     *      - "githubApi"
     *      - "notionApi"
     *      - "slackApi"
     *      - "slackOAuth2Api"
     *      - "freshdeskApi"
     *
     * Example schema response for `freshdeskApi`:
     *  {
     *      "additionalProperties": false,
     *      "type": "object",
     *      "properties": {
     *          "apiKey": { "type": "string" },
     *          "domain": { "type": "string" }
     *      },
     *      "required": ["apiKey", "domain"]
     *  }
     *
     * Use this schema to construct the `data` payload when calling {@see self::createCredential()}.
     *
     * @param string $credentialTypeName The internal credential type name (e.g. "githubApi", "freshdeskApi")
     * @return N8NResponse Schema details
     */
    public function getCredentialSchema(string $credentialTypeName): N8NResponse {
        $response = $this->get("/credentials/schema/{$credentialTypeName}");
        return $this->wrapEntity($response, CredentialSchema::class);
    }
}
