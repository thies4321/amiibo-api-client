<?php

declare(strict_types=1);

namespace Amiibo\Tests\Api;

use Amiibo\Api\Amiibo;
use Amiibo\Client;
use Amiibo\HttpClient\Builder;
use Amiibo\Model\Character;
use Amiibo\Model\GameSeries;
use Amiibo\Model\Series;
use Amiibo\Model\Type;
use DateTimeImmutable;
use Exception;
use Http\Client\Exception as HttpClientException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;

use function file_get_contents;
use function json_encode;

final class AmiiboTest extends TestCase
{
    private function getApiMock(): MockObject|Amiibo
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

    public static function amiiboProvider(): array
    {
        return [
            'collection' => [
                [],
                file_get_contents(__DIR__ . '/../Fixtures/amiibo/collection.json'),
                [
                    \Amiibo\Model\Amiibo::createFromArray([
                        'amiiboSeries' => 'Testseries',
                        'character' => 'Testcharacter',
                        'gameSeries' => 'Testgameseries',
                        'head' => '1234',
                        'image' => 'https://example.com/test1.png',
                        'name' => 'Testname',
                        'release' => [
                            'au' => '1970-01-01',
                            'eu' => '1970-01-02',
                            'jp' => '1970-01-03',
                            'na' => '1970-01-04',
                        ],
                        'tail' => '4321',
                        'type' => 'Testtype',
                    ]),
                    \Amiibo\Model\Amiibo::createFromArray([
                        'amiiboSeries' => 'Testseries2',
                        'character' => 'Testcharacter2',
                        'gameSeries' => 'Testgameseries2',
                        'head' => '5678',
                        'image' => 'https://example.com/test2.png',
                        'name' => 'Testname2',
                        'release' => [
                            'au' => '1970-01-05',
                            'eu' => '1970-01-06',
                            'jp' => '1970-01-07',
                            'na' => '1970-01-08',
                        ],
                        'tail' => '8765',
                        'type' => 'Testtype2',
                    ])
                ]
            ],
            'single' => [
                ['id' => '12345678'],
                file_get_contents(__DIR__ . '/../Fixtures/amiibo/single.json'),
                [
                    \Amiibo\Model\Amiibo::createFromArray([
                        'amiiboSeries' => 'Testseries',
                        'character' => 'Testcharacter',
                        'gameSeries' => 'Testgameseries',
                        'head' => '1234',
                        'image' => 'https://example.com/test1.png',
                        'name' => 'Testname',
                        'release' => [
                            'au' => '1970-01-01',
                            'eu' => '1970-01-02',
                            'jp' => '1970-01-03',
                            'na' => '1970-01-04',
                        ],
                        'tail' => '4321',
                        'type' => 'Testtype',
                    ]),
                ]
            ],
            'none' => [
                [],
                file_get_contents(__DIR__ . '/../Fixtures/none.json'),
                []
            ]
        ];
    }

    /**
     * @throws HttpClientException
     */
    #[DataProvider('amiiboProvider')]
    public function testAmiibo(array $parameters, string $json, array $expectedResult): void
    {
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('amiibo', $parameters)
            ->willReturn($json);

        $result = $api->amiibo($parameters);

        $this->assertEquals($expectedResult, $result);
    }

    public static function typeProvider(): array
    {
        return [
            'collection' => [
                [],
                file_get_contents(__DIR__ . '/../Fixtures/type/collection.json'),
                [
                    Type::createFromArray([
                        'key' => 'key1',
                        'name' => 'name1'
                    ]),
                    Type::createFromArray([
                        'key' => 'key2',
                        'name' => 'name2'
                    ]),
                ]
            ],
            'single' => [
                ['key' => 'key'],
                file_get_contents(__DIR__ . '/../Fixtures/type/single.json'),
                [
                    Type::createFromArray([
                        'key' => 'key',
                        'name' => 'name'
                    ]),
                ]
            ],
            'none' => [
                [],
                file_get_contents(__DIR__ . '/../Fixtures/none.json'),
                []
            ]
        ];
    }

    /**
     * @throws HttpClientException
     */
    #[DataProvider('typeProvider')]
    public function testType(array $parameters, string $json, array $expectedResult): void
    {
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('type', $parameters)
            ->willReturn($json);

        $result = $api->type($parameters);

        $this->assertEquals($expectedResult, $result);
    }

    public static function gameseriesProvider(): array
    {
        return [
            'collection' => [
                [],
                file_get_contents(__DIR__ . '/../Fixtures/gameseries/collection.json'),
                [
                    GameSeries::createFromArray([
                        'key' => 'key1',
                        'name' => 'name1'
                    ]),
                    GameSeries::createFromArray([
                        'key' => 'key2',
                        'name' => 'name2'
                    ]),
                ]
            ],
            'single' => [
                ['key' => 'key'],
                file_get_contents(__DIR__ . '/../Fixtures/gameseries/single.json'),
                [
                    GameSeries::createFromArray([
                        'key' => 'key',
                        'name' => 'name'
                    ]),
                ]
            ],
            'none' => [
                [],
                file_get_contents(__DIR__ . '/../Fixtures/none.json'),
                []
            ]
        ];
    }

    /**
     * @throws HttpClientException
     */
    #[DataProvider('gameseriesProvider')]
    public function testGameseries(array $parameters, string $json, array $expectedResult): void
    {
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('gameseries', $parameters)
            ->willReturn($json);

        $result = $api->gameseries($parameters);

        $this->assertEquals($expectedResult, $result);
    }

    public static function seriesProvider(): array
    {
        return [
            'collection' => [
                [],
                file_get_contents(__DIR__ . '/../Fixtures/series/collection.json'),
                [
                    Series::createFromArray([
                        'key' => 'key1',
                        'name' => 'name1'
                    ]),
                    Series::createFromArray([
                        'key' => 'key2',
                        'name' => 'name2'
                    ]),
                ]
            ],
            'single' => [
                ['key' => 'key'],
                file_get_contents(__DIR__ . '/../Fixtures/series/single.json'),
                [
                    Series::createFromArray([
                        'key' => 'key',
                        'name' => 'name'
                    ]),
                ]
            ],
            'none' => [
                [],
                file_get_contents(__DIR__ . '/../Fixtures/none.json'),
                []
            ]
        ];
    }

    /**
     * @throws HttpClientException
     */
    #[DataProvider('seriesProvider')]
    public function testSeries(array $parameters, string $json, array $expectedResult): void
    {
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('amiiboseries', $parameters)
            ->willReturn($json);

        $result = $api->series($parameters);

        $this->assertEquals($expectedResult, $result);
    }

    public static function characterProvider(): array
    {
        return [
            'collection' => [
                [],
                file_get_contents(__DIR__ . '/../Fixtures/character/collection.json'),
                [
                    Character::createFromArray([
                        'key' => 'key1',
                        'name' => 'name1'
                    ]),
                    Character::createFromArray([
                        'key' => 'key2',
                        'name' => 'name2'
                    ]),
                ]
            ],
            'single' => [
                ['key' => 'key'],
                file_get_contents(__DIR__ . '/../Fixtures/character/single.json'),
                [
                    Character::createFromArray([
                        'key' => 'key',
                        'name' => 'name'
                    ]),
                ]
            ],
            'none' => [
                [],
                file_get_contents(__DIR__ . '/../Fixtures/none.json'),
                []
            ]
        ];
    }

    /**
     * @throws HttpClientException
     */
    #[DataProvider('characterProvider')]
    public function testCharacter(array $parameters, string $json, array $expectedResult): void
    {
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('character', $parameters)
            ->willReturn($json);

        $result = $api->character($parameters);

        $this->assertEquals($expectedResult, $result);
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
            ->willReturn(file_get_contents(__DIR__ . '/../Fixtures/lastupdated.json'));

        $result = $api->lastUpdated();

        $this->assertEquals($expectedResult, $result);
    }
}
