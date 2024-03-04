<?php

declare(strict_types=1);

namespace Amiibo\Api;

use Amiibo\Model\Character;
use Amiibo\Model\GameSeries;
use Amiibo\Model\Series;
use Amiibo\Model\Type;
use Amiibo\Serializer\Normalizer\AmiiboNormalizer;
use Amiibo\Serializer\Normalizer\CharacterNormalizer;
use Amiibo\Serializer\Normalizer\GameSeriesNormalizer;
use Amiibo\Serializer\Normalizer\SeriesNormalizer;
use Amiibo\Serializer\Normalizer\TypeNormalizer;
use DateTimeImmutable;
use Http\Client\Exception as ClientException;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use function json_decode;

final class Amiibo extends AbstractApi
{
    /**
     * @return Amiibo[]
     *
     * @throws ClientException
     */
    public function amiibo(array $parameters = []): array
    {
        $responseBody = $this->get('amiibo', $parameters);

        return $this->serializer->deserialize(
            $responseBody,
            AmiiboNormalizer::TYPE,
            JsonEncoder::FORMAT,
        );
    }

    /**
     * @return Type[]
     *
     * @throws ClientException
     */
    public function type(array $parameters = []): array
    {
        $responseBody = $this->get('type', $parameters);

        return $this->serializer->deserialize(
            $responseBody,
            TypeNormalizer::TYPE,
            JsonEncoder::FORMAT,
        );
    }

    /**
     * @return GameSeries[]
     *
     * @throws ClientException
     */
    public function gameseries(array $parameters = []): array
    {
        $responseBody = $this->get('gameseries', $parameters);

        return $this->serializer->deserialize(
            $responseBody,
            GameSeriesNormalizer::TYPE,
            JsonEncoder::FORMAT,
        );
    }

    /**
     * @return Series[]
     *
     * @throws ClientException
     */
    public function series(array $parameters = []): array
    {
        $responseBody = $this->get('amiiboseries', $parameters);

        return $this->serializer->deserialize(
            $responseBody,
            SeriesNormalizer::TYPE,
            JsonEncoder::FORMAT,
        );
    }

    /**
     * @return Character[]
     *
     * @throws ClientException
     */
    public function character(array $parameters = []): array
    {
        $responsBody = $this->get('character', $parameters);

        return $this->serializer->deserialize(
            $responsBody,
            CharacterNormalizer::TYPE,
            JsonEncoder::FORMAT,
        );
    }

    public function lastUpdated(): DateTimeImmutable
    {
        $responseBody = $this->get('lastupdated');

        return new DateTimeImmutable(json_decode($responseBody, true)['lastUpdated'] ?? '');
    }
}
