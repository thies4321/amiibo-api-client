<?php

declare(strict_types=1);

namespace Amiibo\Model;

final readonly class Type
{
    public function __construct(
        public string $key = '',
        public string $name = '',
    ) {
    }

    public static function createFromArray(array $type): self
    {
        return new self(
            $type['key'] ?? '',
            $type['name'] ?? '',
        );
    }
}
