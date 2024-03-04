<?php

declare(strict_types=1);

namespace Amiibo\Model;

final readonly class Series
{
    public function __construct(
        public string $key = '',
        public string $name = '',
    ) {
    }

    public static function createFromArray(array $series): self
    {
        return new self(
            $series['key'] ?? '',
            $series['name'] ?? '',
        );
    }
}
