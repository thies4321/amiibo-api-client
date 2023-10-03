<?php

declare(strict_types=1);

namespace Amiibo\Exception;

use Exception;

use function sprintf;

final class UnexpectedResponse extends Exception
{
    public static function forResponseCode(int $responseCode, string $message): self
    {
        return new self(sprintf('Unexpected response code: [%d] Message: %s', $responseCode, $message));
    }
}
