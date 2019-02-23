<?php

namespace Concrete\Api\Client\Test;

use Concrete\Api\Client\Client;
use Concrete\Api\Client\ClientFactory;
use Concrete\Api\Client\OAuth2\AuthorizationStateStoreInterface;
use Concrete\Api\Client\OAuth2\Configuration\ConfigurationInterface;
use Concrete\Api\Client\OAuth2\Exception\InvalidStateException;
use Concrete\Api\Client\OAuth2\Middleware\MiddlewareFactory;
use Concrete\Api\Client\Provider\ProviderInterface;
use Concrete\Api\Client\Service\Description\AccountDescription;
use Concrete\Api\Client\Service\Description\SiteDescription;
use Concrete\Api\Client\Service\ServiceCollection;
use Concrete\Api\Client\Service\ServiceDescriptionFactory;
use Concrete\Api\Client\ServiceClientFactory;
use Concrete\OAuth2\Client\Provider\Concrete5;
use Concrete\OAuth2\Client\Provider\Concrete5ResourceOwner;
use GuzzleHttp\Command\Guzzle\Description;
use GuzzleHttp\Command\Guzzle\GuzzleClient;
use kamermans\OAuth2\OAuth2Middleware;
use kamermans\OAuth2\Persistence\TokenPersistenceInterface;
use kamermans\OAuth2\Token\RawToken;
use Mockery as m;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class ClientFactoryTest extends TestCase
{

    use m\Adapter\Phpunit\MockeryPHPUnitIntegration;

    public function testCreateClient()
    {
        $middlewareFactory = m::mock(MiddlewareFactory::class);
        $serviceClientFactory = m::mock(ServiceClientFactory::class);
        $serviceDescriptionFactory = m::mock(ServiceDescriptionFactory::class);
        $serviceCollection = m::mock(ServiceCollection::class);
        $oauth2Middleware = m::mock(OAuth2Middleware::class);
        $configuration = m::mock(ConfigurationInterface::class);

        $middlewareFactory->shouldReceive('create')->andReturn($oauth2Middleware);
        $middlewareFactory->shouldReceive('getConfiguration')->andReturn($configuration);
        $configuration->shouldReceive('getBaseUrl')->andReturn(
            'http://api.test.com'
        );

        $factory = new ClientFactory(
            $middlewareFactory, $serviceClientFactory, $serviceDescriptionFactory, $serviceCollection
        );
        $client = $factory->create();
        $this->assertInstanceOf(Client::class, $client);
    }

}