<?php

declare(strict_types=1);

namespace Amiibo\Tests;

use Amiibo\Client;
use Http\Client\Common\HttpMethodsClient;
use PHPUnit\Framework\TestCase;

final class ClientTest extends TestCase
{
    public function testCreateClient(): void
    {
        $client = new Client();

        $this->assertInstanceOf(Client::class, $client);
        $this->assertInstanceOf(HttpMethodsClient::class, $client->getHttpClient());
    }
}
