<?php

declare(strict_types=1);

namespace Amiibo\Serializer\Normalizer;

use Amiibo\Model\AmiiboCollection;
use RuntimeException;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

use function array_map;

class AmiiboCollectionNormalizer extends AbstractNormalizer
{
    public function denormalize(mixed $data, string $type, string $format = null, array $context = []): AmiiboCollection
    {
        $amiiboNormalizer = new AmiiboNormalizer();

        return new AmiiboCollection(
            array_map(function($amiibo) use ($amiiboNormalizer, $type, $format, $context) {
                return $amiiboNormalizer->denormalize($amiibo, $type, $format, $context);
            }, $data['amiibo'])
        );
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null): bool
    {
        return $type === AmiiboCollection::class;
    }

    public function normalize(mixed $object, string $format = null, array $context = []): void
    {
        throw new RuntimeException('This should never be called');
    }

    public function supportsNormalization(mixed $data, string $format = null): false
    {
        return false;
    }
}
