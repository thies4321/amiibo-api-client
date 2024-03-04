<?php

declare(strict_types=1);

namespace Amiibo\HttpClient\Plugin;

use Amiibo\Exception\UnexpectedResponse;
use Http\Client\Common\Plugin;
use Http\Promise\Promise;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

use function json_decode;

final class ExceptionThrower implements Plugin
{
    /**
     * @throws UnexpectedResponse
     */
    public function handleRequest(RequestInterface $request, callable $next, callable $first): Promise
    {
        return $next($request)->then(function (ResponseInterface $response): ResponseInterface {
            $status = $response->getStatusCode();

            if ($status >= 400 && $status < 600) {
                $body = json_decode($response->getBody()->getContents(), true);
                throw UnexpectedResponse::forResponseCode($status, $body['error']);
            }

            return $response;
        });
    }
}
