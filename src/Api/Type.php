<?php

declare(strict_types=1);

namespace Amiibo\Api;

use Amiibo\Model\TypeCollection;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

final class Type extends AbstractApi
{
    private const URI = 'type';

    public function all(): TypeCollection
    {
        return $this->serializer->deserialize(
            $this->get(self::URI),
            TypeCollection::class,
            JsonEncoder::FORMAT,
        );
    }
}
