<?php

declare(strict_types=1);

namespace Amiibo\Model;

final class Amiibo
{
    public function __construct(
        public ?string $ammiboSeries,
        public ?string $character,
        public ?string $gameSeries,
        public ?array $games3DS,
        public ?array $gamesSwitch,
        public ?array $gamesWiiU,
        public ?string $head,
        public ?string $image,
        public ?string $name,
        public ?array $release,
        public ?string $tail,
        public ?string $type,
    ) {
    }
}
