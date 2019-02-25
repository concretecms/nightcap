<?php

namespace Concrete\Nightcap\Test;

use Concrete\Nightcap\Client;
use Concrete\Nightcap\ClientFactory;
use Concrete\Nightcap\OAuth2\AuthorizationStateStoreInterface;
use Concrete\Nightcap\OAuth2\Configuration\ConfigurationInterface;
use Concrete\Nightcap\OAuth2\Exception\InvalidStateException;
use Concrete\Nightcap\OAuth2\Middleware\MiddlewareFactory;
use Concrete\Nightcap\Provider\ProviderInterface;
use Concrete\Nightcap\Service\Description\AccountDescription;
use Concrete\Nightcap\Service\Description\SiteDescription;
use Concrete\Nightcap\Service\ServiceCollection;
use Concrete\Nightcap\Service\ServiceDescriptionFactory;
use Concrete\Nightcap\ServiceClientFactory;
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