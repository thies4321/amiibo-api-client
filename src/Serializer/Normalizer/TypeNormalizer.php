<?php

declare(strict_types=1);

namespace Amiibo\Serializer\Normalizer;

use Amiibo\Model\Type;
use RuntimeException;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class TypeNormalizer extends AbstractNormalizer
{
    public function denormalize(mixed $data, string $type, string $format = null, array $context = []): Type
    {
        return new Type(
            $data['key'] ?? null,
            $data['name'] ?? null,
        );
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null): bool
    {
        return $type === Type::class;
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
