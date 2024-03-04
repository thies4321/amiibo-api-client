<?php

declare(strict_types=1);

namespace Amiibo\Api;

use Amiibo\Client;
use Amiibo\Serializer\Normalizer\AmiiboNormalizer;
use Amiibo\Serializer\Normalizer\CharacterNormalizer;
use Amiibo\Serializer\Normalizer\GameSeriesNormalizer;
use Amiibo\Serializer\Normalizer\SeriesNormalizer;
use Amiibo\Serializer\Normalizer\TypeNormalizer;
use Http\Client\Exception as HttpClientException;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;

use function http_build_query;
use function sprintf;

abstract class AbstractApi
{
    private const URI_PREFIX = '/api/';

    private Client $client;
    protected Serializer $serializer;

    public function __construct(Client $client, Serializer $serializer = null)
    {
        $this->client = $client;
        $this->serializer = $serializer ?? new Serializer([
            new AmiiboNormalizer(),
            new CharacterNormalizer(),
            new GameSeriesNormalizer(),
            new SeriesNormalizer(),
            new TypeNormalizer(),
        ], [
            new JsonEncoder()
        ]);
    }

    /**
     * @throws HttpClientException
     */
    protected function get(string $uri, array $params = [], array $headers = []): string
    {
        $response = $this->client->getHttpClient()->get(
            sprintf(
                '%s%s?%s',
                self::URI_PREFIX,
                $uri,
                http_build_query($params)
            ),
            $headers
        );

        return $response->getBody()->getContents();
    }
}
