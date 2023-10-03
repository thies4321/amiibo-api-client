<?php

declare(strict_types=1);

namespace Amiibo\Model;

final class Type
{
    public function __construct(
        public ?string $key,
        public ?string $name,
    ) {
    }
}
