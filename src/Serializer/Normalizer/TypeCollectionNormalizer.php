<?php

declare(strict_types=1);

namespace Amiibo\Serializer\Normalizer;

use Amiibo\Model\TypeCollection;
use RuntimeException;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

use function array_map;

class TypeCollectionNormalizer extends AbstractNormalizer
{
    public function denormalize(mixed $data, string $type, string $format = null, array $context = [])
    {
        $typeNormalizer = new TypeNormalizer();

        return new TypeCollection(
            array_map(function($amiiboType) use ($typeNormalizer, $type, $format, $context) {
                return $typeNormalizer->denormalize($amiiboType, $type, $format, $context);
            }, $data['amiibo'])
        );
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null): bool
    {
        return $type === TypeCollection::class;
    }

    public function normalize(mixed $object, string $format = null, array $context = [])
    {
        throw new RuntimeException('This should never be called');
    }

    public function supportsNormalization(mixed $data, string $format = null): false
    {
        return false;
    }
}
