<?php

declare(strict_types=1);

namespace Amiibo\Tests\Api;

use Amiibo\Api\Amiibo;
use Amiibo\Client;
use Amiibo\HttpClient\Builder;
use DateTimeImmutable;
use Exception;
use Http\Client\Exception as HttpClientException;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;

use function json_encode;

final class AmiiboTest extends TestCase
{
    private function getApiMock()
    {
        $httpClient = $this->getMockBuilder(ClientInterface::class)
            ->onlyMethods(['sendRequest'])
            ->getMock();
        $httpClient
            ->expects($this->any())
            ->method('sendRequest');

        $builder = new Builder($httpClient);

        $client = new Client($builder);

        return $this->getMockBuilder(Amiibo::class)
            ->onlyMethods(['get'])
            ->setConstructorArgs([$client, null])
            ->getMock();
    }

    /**
     * @throws HttpClientException
     * @throws Exception
     */
    public function testLastUpdated(): void
    {
        $lastUpdated = '2019-03-18T16:34:10.688417';
        $expectedResult = new DateTimeImmutable($lastUpdated);

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('lastupdated')
            ->willReturn(json_encode(['lastUpdated' => $lastUpdated]));

        $result = $api->lastUpdated();

        $this->assertEquals($expectedResult, $result);
    }
}
