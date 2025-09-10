<?php

namespace UsmanZahid\N8n\Tests\Unit\Clients;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use UsmanZahid\N8n\Clients\ApiClient;
use UsmanZahid\N8n\Helpers\RequestHelper;
use UsmanZahid\N8n\Response\N8nResponse;

class ApiClientTest extends TestCase {
    private $mockHttp;
    private $client;

    protected function setUp(): void {
        $this->mockHttp = $this->createMock(Client::class);

        // Anonymous subclass to expose protected methods
        $this->client = new class('http://localhost', 'test-key', $this->mockHttp) extends ApiClient {
            public function __construct($baseUrl, $apiKey, $http) {
                parent::__construct($baseUrl, $apiKey);
                $this->http = $http; // override with mock
            }

            public function callRequest($method, $endpoint, $data = []) {
                return $this->request($method, $endpoint, $data);
            }

            public function callGet($endpoint, $query = []) {
                return $this->get($endpoint, $query);
            }

            public function callPost($endpoint, $data = []) {
                return $this->post($endpoint, $data);
            }

            public function callPut($endpoint, $data = []) {
                return $this->put($endpoint, $data);
            }

            public function callPatch($endpoint, $data = []) {
                return $this->patch($endpoint, $data);
            }

            public function callDelete($endpoint) {
                return $this->delete($endpoint);
            }

            public function callWrapEntity(array $raw, ?string $entityClass = null) {
                return $this->wrapEntity($raw, $entityClass);
            }
        };
    }

    public function testRequestReturnsDecodedJson() {
        $response = $this->createMock(ResponseInterface::class);
        $stream = $this->createMock(StreamInterface::class);

        $this->mockHttp->method('request')->willReturn($response);
        $response->method('getBody')->willReturn($stream);
        $stream->method('__toString')->willReturn('{"foo":"bar"}');
        $response->method('getStatusCode')->willReturn(200);

        $result = $this->client->callRequest('GET', '/test');

        $this->assertTrue($result['success']);
        $this->assertEquals(['foo' => 'bar'], $result['data']);
        $this->assertEquals(200, $result['code']);
    }

    public function testRequestHandlesEmptyBody() {
        $response = $this->createMock(ResponseInterface::class);
        $stream = $this->createMock(StreamInterface::class);

        $this->mockHttp->method('request')->willReturn($response);
        $response->method('getBody')->willReturn($stream);
        $stream->method('__toString')->willReturn('');
        $response->method('getStatusCode')->willReturn(204);

        $result = $this->client->callRequest('GET', '/test');
        $this->assertTrue($result['success']);
        $this->assertNull($result['data']);
        $this->assertEquals(204, $result['code']);
    }

    public function testRequestHandlesException() {
        $this->mockHttp->method('request')->willThrowException(
            $this->createMock(GuzzleException::class)
        );

        // fake RequestHelper response
        $expected = ['success' => false, 'data' => null, 'message' => 'error', 'code' => 500];
        RequestHelper::staticExpects($this->any()); // adjust if you make RequestHelper static mockable

        $result = $this->client->callRequest('GET', '/fail');
        $this->assertArrayHasKey('success', $result);
        $this->assertFalse($result['success']);
    }

    public function testConvenienceMethodsDelegateToRequest() {
        $response = $this->createMock(ResponseInterface::class);
        $stream = $this->createMock(StreamInterface::class);
        $this->mockHttp->method('request')->willReturn($response);
        $response->method('getBody')->willReturn($stream);
        $stream->method('__toString')->willReturn('{}');
        $response->method('getStatusCode')->willReturn(200);

        $this->assertTrue($this->client->callGet('/x')['success']);
        $this->assertTrue($this->client->callPost('/x')['success']);
        $this->assertTrue($this->client->callPut('/x')['success']);
        $this->assertTrue($this->client->callPatch('/x')['success']);
        $this->assertTrue($this->client->callDelete('/x')['success']);
    }

    public function testWrapEntityWithHydration() {
        // fake entity class
        $entityClass = new class {
            public $data;

            public function __construct($data) {
                $this->data = $data;
            }
        };

        $raw = ['success' => true, 'data' => ['foo' => 'bar'], 'code' => 200];
        $wrapped = $this->client->callWrapEntity($raw, $entityClass::class);

        $this->assertInstanceOf(N8nResponse::class, $wrapped);
        $this->assertTrue($wrapped->success);
        $this->assertInstanceOf($entityClass::class, $wrapped->data);
    }

    public function testWrapEntityWithoutHydration() {
        $raw = ['success' => true, 'data' => ['foo' => 'bar'], 'code' => 200];
        $wrapped = $this->client->callWrapEntity($raw, null);

        $this->assertInstanceOf(N8nResponse::class, $wrapped);
        $this->assertEquals(['foo' => 'bar'], $wrapped->data);
    }
}
