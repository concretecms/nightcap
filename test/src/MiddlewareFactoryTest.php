<?php

namespace Concrete\Api\Client\Test;

use Concrete\Api\Client\OAuth2\Configuration\ClientCredentialsConfiguration;
use Concrete\Api\Client\OAuth2\Configuration\ConfigurationInterface;
use Concrete\Api\Client\OAuth2\Middleware\Client\AuthorizationClientFactory;
use Concrete\Api\Client\OAuth2\Middleware\GrantType\ClientCredentialsGrantType;
use Concrete\Api\Client\OAuth2\Middleware\GrantType\GrantTypeInterface;
use Concrete\Api\Client\OAuth2\Middleware\MiddlewareFactory;
use GuzzleHttp\Client;
use kamermans\OAuth2\GrantType\ClientCredentials;
use kamermans\OAuth2\Persistence\TokenPersistenceInterface;
use Mockery as m;
use PHPUnit\Framework\TestCase;

class MiddlewareFactoryTest extends TestCase
{

    use m\Adapter\Phpunit\MockeryPHPUnitIntegration;

    public function testFactoryCreate()
    {
        $client = m::mock(Client::class);
        $configuration = m::mock(ClientCredentialsConfiguration::class);
        $clientFactory = m::mock(AuthorizationClientFactory::class);
        $grantType = m::mock(ClientCredentialsGrantType::class);
        $middlewareGrantType = m::mock(ClientCredentials::class);
        $tokenPersistence = m::mock(TokenPersistenceInterface::class);

        $clientFactory->shouldReceive('createClient')->andReturn($client);
        $grantType->shouldReceive('createMiddlewareGrantType')->andReturn($middlewareGrantType);
        $grantType->shouldReceive('createMiddlewareRefreshToken')->andReturn(null);
        $grantType->shouldReceive('supportsRefreshTokens')->andReturn(false);
        $factory = new MiddlewareFactory($configuration, $grantType, $clientFactory, $tokenPersistence);
        $clieint = $factory->create();
    }

}