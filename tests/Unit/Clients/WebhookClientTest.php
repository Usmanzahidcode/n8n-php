<?php

namespace UsmanZahid\N8n\Tests\Unit\Clients;

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use UsmanZahid\N8n\Clients\WebhookClient;
use UsmanZahid\N8n\Enums\RequestMethod;
use UsmanZahid\N8n\Enums\WebhookMode;
use UsmanZahid\N8n\Response\N8nResponse;

class WebhookClientTest extends TestCase
{
    public function testSendReturnsSuccessResponse()
    {
        $mockHttp = $this->createMock(Client::class);
        $client = new WebhookClient('http://localhost', WebhookMode::Production, RequestMethod::Post);

        $ref = new \ReflectionClass($client);
        $prop = $ref->getProperty('http');
        $prop->setValue($client, $mockHttp);

        $response = $this->createMock(ResponseInterface::class);
        $stream = $this->createMock(StreamInterface::class);

        $mockHttp->method('request')->willReturn($response);
        $response->method('getBody')->willReturn($stream);
        $stream->method('__toString')->willReturn('{"ok":true}');
        $response->method('getStatusCode')->willReturn(200);

        $result = $client->send('test-webhook');

        $this->assertInstanceOf(N8nResponse::class, $result);
        $this->assertTrue($result->success);
        $this->assertEquals(['ok' => true], $result->data);
        $this->assertEquals(200, $result->code);
    }

    public function testWithAndWithoutBasicAuthDoNotBreak()
    {
        $client = new WebhookClient('http://localhost');
        $this->assertInstanceOf(WebhookClient::class, $client->withBasicAuth('u','p'));
        $this->assertInstanceOf(WebhookClient::class, $client->withoutBasicAuth());
    }
}
