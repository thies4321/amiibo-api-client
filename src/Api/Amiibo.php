<?php

declare(strict_types=1);

namespace Amiibo\Api;

use Amiibo\Model\AmiiboCollection;

use Http\Client\Exception as HttpClientException;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use function array_merge;

final class Amiibo extends AbstractApi
{
    private const URI = 'amiibo';

    /**
     * @throws HttpClientException
     */
    private function getCollectionByNameAndValue(string $name, string $value)
    {
        return $this->serializer->deserialize(
            $this->get(self::URI, [$name => $value]),
            AmiiboCollection::class,
            JsonEncoder::FORMAT,
        );
    }

    /**
     * @throws HttpClientException
     */
    public function all(): AmiiboCollection
    {
        return $this->serializer->deserialize(
            $this->get(self::URI),
            AmiiboCollection::class,
            JsonEncoder::FORMAT,
        );
    }

    /**
     * @throws HttpClientException
     */
    public function series(string $amiiboSeries): AmiiboCollection
    {
        return $this->getCollectionByNameAndValue('amiiboSeries', $amiiboSeries);
    }

    /**
     * @throws HttpClientException
     */
    public function character(string $character): AmiiboCollection
    {
        return $this->getCollectionByNameAndValue('character', $character);
    }

    /**
     * @throws HttpClientException
     */
    public function gameSeries(string $gameSeries): AmiiboCollection
    {
        return $this->getCollectionByNameAndValue('gameseries', $gameSeries);
    }

    /**
     * @throws HttpClientException
     */
    public function head(string $head): AmiiboCollection
    {
        return $this->getCollectionByNameAndValue('head', $head);
    }

    /**
     * @throws HttpClientException
     */
    public function name(string $name): AmiiboCollection
    {
        return $this->getCollectionByNameAndValue('name', $name);
    }

    /**
     * @throws HttpClientException
     */
    public function showGames(array $filters = []): AmiiboCollection
    {
        return $this->serializer->deserialize(
            $this->get(self::URI, array_merge(['showgames' => true], $filters)),
            AmiiboCollection::class,
            JsonEncoder::FORMAT,
        );
    }

    /**
     * @throws HttpClientException
     */
    public function showUsage(array $filters = []): AmiiboCollection
    {
        return $this->serializer->deserialize(
            $this->get(self::URI, array_merge(['showusage' => true], $filters)),
            AmiiboCollection::class,
            JsonEncoder::FORMAT,
        );
    }
}
