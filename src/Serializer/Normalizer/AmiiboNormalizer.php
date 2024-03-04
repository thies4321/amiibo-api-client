<?php

declare(strict_types=1);

namespace Amiibo\Serializer\Normalizer;

use Amiibo\Model\Amiibo;
use RuntimeException;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

use function array_map;

final class AmiiboNormalizer extends AbstractNormalizer
{
    public const TYPE = 'AMIIBO';

    /**
     * @return Amiibo[]
     */
    public function denormalize(mixed $data, string $type, string $format = null, array $context = []): array
    {
        if (! empty($data['amiibo']) && ! isset($data['amiibo'][0])) {
            return [Amiibo::createFromArray($data['amiibo'])];
        }

        return array_map(function (array $amiiboData) {
            return Amiibo::createFromArray($amiiboData);
        }, $data['amiibo'] ?? []);
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null): bool
    {
        return $type === self::TYPE;
    }

    public function normalize(mixed $object, string $format = null, array $context = []): void
    {
        throw new RuntimeException('This should never be called');
    }

    public function supportsNormalization(mixed $data, string $format = null): bool
    {
        return false;
    }
}
