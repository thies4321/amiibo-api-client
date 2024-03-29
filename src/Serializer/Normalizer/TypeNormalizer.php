<?php

declare(strict_types=1);

namespace Amiibo\Serializer\Normalizer;

use Amiibo\Model\Type;
use RuntimeException;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

use function array_map;

/**
 * @method array getSupportedTypes(?string $format)
 */
final class TypeNormalizer extends AbstractNormalizer
{
    public const TYPE = 'TYPE';

    /**
     * @return Type[]
     */
    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): array
    {
        if (! empty($data['amiibo']) && ! isset($data['amiibo'][0])) {
            return [Type::createFromArray($data['amiibo'])];
        }

        return array_map(function (array $typeData) {
            return Type::createFromArray($typeData);
        }, $data['amiibo'] ?? []);
    }

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null): bool
    {
        return $type === self::TYPE;
    }

    public function normalize(mixed $object, ?string $format = null, array $context = []): void
    {
        throw new RuntimeException('This should never be called');
    }

    public function supportsNormalization(mixed $data, ?string $format = null): bool
    {
        return false;
    }
}
