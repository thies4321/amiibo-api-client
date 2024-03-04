<?php

declare(strict_types=1);

namespace Amiibo\Model;

final readonly class GameSeries
{
    public function __construct(
        public string $key = '',
        public string $name = '',
    ) {
    }

    public static function createFromArray(array $gameSeries): self
    {
        return new self(
            $gameSeries['key'] ?? '',
            $gameSeries['name'] ?? '',
        );
    }
}
