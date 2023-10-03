<?php

declare(strict_types=1);

namespace Amiibo\Model;

use Countable;
use Iterator;

use function count;

class TypeCollection implements Iterator, Countable
{
    public function __construct(
        /** @var Type[] $types */
        public array $types,
        private int $position = 0,
    ) {
    }

    public function current(): Type
    {
        return $this->types[$this->position];
    }

    public function next(): void
    {
        ++$this->position;
    }

    public function key(): int
    {
        return $this->position;
    }

    public function valid(): bool
    {
        return isset($this->types[$this->position]);
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    public function count(): int
    {
        return count($this->types);
    }
}
