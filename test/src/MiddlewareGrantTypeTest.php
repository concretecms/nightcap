<?php

namespace Concrete\Nightcap\Test;

use Concrete\Nightcap\OAuth2\Configuration\AuthorizationCodeConfiguration;
use Concrete\Nightcap\OAuth2\Configuration\ClientCredentialsConfiguration;
use Concrete\Nightcap\OAuth2\Configuration\PasswordCredentialsConfiguration;
use Concrete\Nightcap\OAuth2\Middleware\GrantType\AuthorizationCodeGrantType;
use Concrete\Nightcap\OAuth2\Middleware\GrantType\ClientCredentialsGrantType;
use Concrete\Nightcap\OAuth2\Middleware\GrantType\PasswordCredentialsGrantType;
use Concrete\Nightcap\OAuth2\Middleware\MiddlewareFactory;
use GuzzleHttp\Client;
use kamermans\OAuth2\GrantType\AuthorizationCode;
use kamermans\OAuth2\GrantType\ClientCredentials;
use kamermans\OAuth2\GrantType\PasswordCredentials;
use kamermans\OAuth2\Persistence\TokenPersistenceInterface;
use Mockery as m;
use PHPUnit\Framework\TestCase;

class MiddlewareGrantTypeTest extends TestCase
{

    use m\Adapter\Phpunit\MockeryPHPUnitIntegration;

    public function testCreateClientCredentialsMiddleware()
    {
        $client = m::mock(Client::class);
        $configuration = m::mock(ClientCredentialsConfiguration::class);
        $configuration->shouldReceive('getBaseUrl');
        $configuration->shouldReceive('getClientId');
        $configuration->shouldReceive('getClientSecret');
        $configuration->shouldReceive('getScopes')->andReturn([]);
        $factory = new ClientCredentialsGrantType();
        $baseGrant = $factory->createMiddlewareGrantType($client, $configuration);
        $this->assertInstanceOf(ClientCredentials::class, $baseGrant);
    }

    public function testPasswordCredentialsMiddleware()
    {
        $client = m::mock(Client::class);
        $configuration = m::mock(PasswordCredentialsConfiguration::class);
        $configuration->shouldReceive('getBaseUrl');
        $configuration->shouldReceive('getClientId');
        $configuration->shouldReceive('getUsername');
        $configuration->shouldReceive('getPassword');
        $configuration->shouldReceive('getScopes')->andReturn([]);
        $factory = new PasswordCredentialsGrantType();
        $baseGrant = $factory->createMiddlewareGrantType($client, $configuration);
        $this->assertInstanceOf(PasswordCredentials::class, $baseGrant);
    }

    public function testAuthorizationCodeMiddleware()
    {
        $client = m::mock(Client::class);
        $configuration = m::mock(AuthorizationCodeConfiguration::class);
        $configuration->shouldReceive('getBaseUrl');
        $configuration->shouldReceive('getClientId');
        $configuration->shouldReceive('getClientSecret');
        $configuration->shouldReceive('getRedirectUri');
        $configuration->shouldReceive('getAuthCode');
        $factory = new AuthorizationCodeGrantType();
        $baseGrant = $factory->createMiddlewareGrantType($client, $configuration);
        $this->assertInstanceOf(AuthorizationCode::class, $baseGrant);
    }



}