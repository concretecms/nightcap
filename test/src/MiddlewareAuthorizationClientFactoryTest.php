<?php

namespace Concrete\Nightcap\Test;

use Concrete\OAuth2\Client\Provider\Concrete5;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Uri;
use Mockery as m;
use PHPUnit\Framework\TestCase;
use Concrete\Nightcap\OAuth2\Middleware\Client\AuthorizationClientFactory;
use Concrete\Nightcap\OAuth2\Configuration\ConfigurationInterface;

class MiddlewareAuthorizationClientFactoryTest extends TestCase
{

    use m\Adapter\Phpunit\MockeryPHPUnitIntegration;

    public function testClientCreate()
    {
        $oauthProvider = m::mock(Concrete5::class);
        $oauthProvider->shouldReceive('getBaseAccessTokenUrl')->andReturn('https://api.concrete5site.com/oauth/2.0/token');
        $factory = new AuthorizationClientFactory($oauthProvider);
        $client = $factory->createClient();
        $this->assertInstanceOf(Client::class, $client);
        $baseUri = $client->getConfig('base_uri');
        $this->assertInstanceOf(Uri::class, $baseUri);
        $this->assertEquals('https://api.concrete5site.com/oauth/2.0/token', (string) $baseUri);
    }

}