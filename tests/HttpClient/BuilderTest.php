<?php

namespace Amiibo\Tests\HttpClient;

use Amiibo\HttpClient\Builder;
use Http\Client\Common\HttpMethodsClientInterface;
use Http\Client\Common\Plugin;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

final class BuilderTest extends TestCase
{
    /**
     * @var Builder
     */
    private $subject;

    /**
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function setUp(): void
    {
        $this->subject = new Builder(
            $this->createMock(ClientInterface::class),
            $this->createMock(RequestFactoryInterface::class),
            $this->createMock(StreamFactoryInterface::class)
        );
    }

    public function testAddPluginShouldInvalidateHttpClient(): void
    {
        $client = $this->subject->getHttpClient();

        $this->subject->addPlugin($this->createMock(Plugin::class));

        $this->assertNotSame($client, $this->subject->getHttpClient());
    }

    public function testRemovePluginShouldInvalidateHttpClient(): void
    {
        $this->subject->addPlugin($this->createMock(Plugin::class));

        $client = $this->subject->getHttpClient();

        $this->subject->removePlugin(Plugin::class);

        $this->assertNotSame($client, $this->subject->getHttpClient());
    }

    public function testHttpClientShouldBeAnHttpMethodsClient(): void
    {
        $this->assertInstanceOf(HttpMethodsClientInterface::class, $this->subject->getHttpClient());
    }

    public function testStreamFactoryShouldBeAStreamFactory(): void
    {
        $this->assertInstanceOf(StreamFactoryInterface::class, $this->subject->getStreamFactory());
    }
}
