<?php

declare(strict_types=1);

namespace Amiibo\Model;

use Countable;
use Iterator;

final class AmiiboCollection implements Iterator, Countable
{
    public function __construct(
        /** @var Amiibo[] */
        public readonly array $amiibos,
        private int $position = 0,
    ) {
    }

    public function current(): Amiibo
    {
        return $this->amiibos[$this->position];
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
        return isset($this->amiibos[$this->position]);
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    public function count(): int
    {
        return count($this->amiibos);
    }
}
