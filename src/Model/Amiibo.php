<?php

declare(strict_types=1);

namespace Amiibo\Model;

use DateTimeImmutable;

use function sprintf;

final readonly class Amiibo
{
    public function __construct(
        public string $ammiboSeries = '',
        public string $character = '',
        public string $gameSeries = '',
        public array  $games3DS = [],
        public array  $gamesSwitch = [],
        public array  $gamesWiiU = [],
        public string $head = '',
        public string $image = '',
        public string $name = '',
        public array  $release = [],
        public string $tail = '',
        public string $type = '',
    ) {
    }

    public static function createFromArray(array $amiibo): self
    {
        $releases = $amiibo['release'] ?? [];

        foreach ($releases as $country => $date) {
            if ($date === null) {
                continue;
            }

            $releases[$country] = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', sprintf('%s 00:00:00', $date));
        }

        return new self(
            $amiibo['amiiboSeries'] ?? '',
            $amiibo['character'] ?? '',
            $amiibo['gameSeries'] ?? '',
            $amiibo['games3DS'] ?? [],
            $amiibo['gamesSwitch'] ?? [],
            $amiibo['gamesWiiU'] ?? [],
            $amiibo['head'] ?? '',
            $amiibo['image'] ?? '',
            $amiibo['name'] ?? '',
            $releases,
            $amiibo['tail'] ?? '',
            $amiibo['type'] ?? '',
        );
    }
}
