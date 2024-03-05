<?php

declare(strict_types=1);

namespace Amiibo;

use Amiibo\Api\Amiibo;
use Amiibo\HttpClient\Builder;
use Amiibo\HttpClient\Plugin\ExceptionThrower;
use Http\Client\Common\HttpMethodsClientInterface;
use Http\Client\Common\Plugin\AddHostPlugin;
use Http\Client\Common\Plugin\HeaderDefaultsPlugin;
use Http\Client\Common\Plugin\RedirectPlugin;

final class Client
{
    private const BASE_URL = 'https://amiiboapi.com/';
    private const USER_AGENT = 'amiibo-api-client/1.0.0';

    private Builder $httpClientBuilder;

    public function __construct(?Builder $httpClientBuilder = null)
    {
        $this->httpClientBuilder = $builder = $httpClientBuilder ?? new Builder();

        $builder->addPlugin(new ExceptionThrower());
        $builder->addPlugin(new HeaderDefaultsPlugin([
            'User-Agent' => self::USER_AGENT,
        ]));
        $builder->addPlugin(new RedirectPlugin());

        $this->setUrl(self::BASE_URL);
    }

    public function setUrl(string $url): void
    {
        $uri = $this->httpClientBuilder->getUriFactory()->createUri($url);

        $this->httpClientBuilder->removePlugin(AddHostPlugin::class);
        $this->httpClientBuilder->addPlugin(new AddHostPlugin($uri));
    }

    public function getHttpClient(): HttpMethodsClientInterface
    {
        return $this->httpClientBuilder->getHttpClient();
    }

    public function amiibo(): Amiibo
    {
        return new Amiibo($this);
    }
}
