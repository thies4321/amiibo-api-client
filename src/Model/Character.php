<?php

declare(strict_types=1);

namespace Amiibo\Model;

final readonly class Character
{
    public function __construct(
        public string $key = '',
        public string $name = '',
    ) {
    }

    public static function createFromArray(array $character): self
    {
        return new self(
            $character['key'] ?? '',
            $character['name'] ?? '',
        );
    }
}
