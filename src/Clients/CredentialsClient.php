<?php

namespace Usman\N8n\Clients;

use Usman\N8n\BaseClient;
use Usman\N8n\Entities\Credential\Credential;
use Usman\N8n\Entities\Credential\CredentialSchema;

class CredentialsClient extends BaseClient {
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
     * @return Credential Hydrated credential entity with id, name, type, createdAt, updatedAt
     */
    public function createCredential(array $payload): Credential {
        $response = $this->post('/credentials', $payload);
        return new Credential($response);
    }

    /**
     * Delete a credential by ID.
     *
     * API: DELETE /credentials/{id}
     *
     * @param string $id The credential ID
     * @return Credential Hydrated credential entity (id, name, type, createdAt, updatedAt)
     */
    public function deleteCredential(string $id): Credential {
        $response = $this->delete("/credentials/{$id}");
        return new Credential($response);
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
     * @return CredentialSchema Hydrated schema entity
     */
    public function getCredentialSchema(string $credentialTypeName): CredentialSchema {
        $response = $this->get("/credentials/schema/{$credentialTypeName}");
        return new CredentialSchema($response);
    }

}
