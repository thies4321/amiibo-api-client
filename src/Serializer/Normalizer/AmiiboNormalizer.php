<?php

declare(strict_types=1);

namespace Amiibo\Serializer\Normalizer;

use Amiibo\Model\Amiibo;
use DateTimeImmutable;
use RuntimeException;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

use function sprintf;

class AmiiboNormalizer extends AbstractNormalizer
{
    public function denormalize(mixed $data, string $type, string $format = null, array $context = []): Amiibo
    {
        $releases = $data['release'] ?? null;

        if ($releases !== null) {
            foreach ($releases as $country => $date) {
                if ($date === null) {
                    continue;
                }

                $releases[$country] = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', sprintf('%s 00:00:00', $date));
            }
        }

        return new Amiibo(
            $data['amiiboSeries'] ?? null,
            $data['character'] ?? null,
            $data['gameSeries'] ?? null,
            $data['games3DS'] ?? null,
            $data['gamesSwitch'] ?? null,
            $data['gamesWiiU'] ?? null,
            $data['head'] ?? null,
            $data['image'] ?? null,
            $data['name'] ?? null,
            $releases,
            $data['tail'] ?? null,
            $data['type'] ?? null,
        );
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null): bool
    {
        return $type === Amiibo::class;
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
