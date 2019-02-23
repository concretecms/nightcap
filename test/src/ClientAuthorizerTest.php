<?php

namespace Concrete\Api\Client\Test;

use Concrete\Api\Client\Client;
use Concrete\Api\Client\ClientFactory;
use Concrete\Api\Client\OAuth2\Authorization\ClientAuthorizer;
use Concrete\Api\Client\OAuth2\Authorization\Redirect\RedirectorInterface;
use Concrete\Api\Client\OAuth2\Authorization\StateStore\StateStoreInterface;
use Concrete\Api\Client\OAuth2\Configuration\AuthorizationCodeConfiguration;
use Concrete\Api\Client\OAuth2\Middleware\MiddlewareFactory;
use Concrete\Api\Client\Service\Description\SystemDescription;
use Concrete\Api\Client\Service\ServiceCollection;
use Concrete\Api\Client\Service\ServiceDescriptionFactory;
use Concrete\Api\Client\ServiceClientFactory;
use Concrete\OAuth2\Client\Provider\Concrete5;
use GuzzleHttp\Command\Guzzle\Description;
use GuzzleHttp\Command\Guzzle\GuzzleClient;
use kamermans\OAuth2\Persistence\TokenPersistenceInterface;
use League\OAuth2\Client\Provider\AbstractProvider;
use Mockery as m;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class ClientAuthorizerTest extends TestCase
{

    use m\Adapter\Phpunit\MockeryPHPUnitIntegration;

    /**
     * @expectedException \Concrete\Api\Client\OAuth2\Exception\InvalidStateException
     */
    public function testAuthorizeClientFailure()
    {
        $oauthProvider = m::mock(AbstractProvider::class);
        $tokenStore = m::mock(TokenPersistenceInterface::class);
        $stateStore = m::mock(StateStoreInterface::class);
        $redirector = m::mock(RedirectorInterface::class);
        $factory = m::mock(ClientFactory::class);

        $stateStore->shouldReceive('get')->andReturn('12345doesnotmatch');

        $code = 'asdfg';
        $state = '12345';

        $authorizer = new ClientAuthorizer($oauthProvider, $tokenStore, $stateStore, $redirector, $factory);
        $owner = $authorizer->authorizeClient($code, $state);
    }

    public function testAuthorizeClientSuccess()
    {
        $middlewareFactory = m::mock(MiddlewareFactory::class);
        $configuration = m::mock(AuthorizationCodeConfiguration::class);

        $oauthProvider = m::mock(AbstractProvider::class);
        $tokenStore = m::mock(TokenPersistenceInterface::class);
        $stateStore = m::mock(StateStoreInterface::class);
        $redirector = m::mock(RedirectorInterface::class);
        $factory = m::mock(ClientFactory::class);
        $client = m::mock(Client::class);
        $serviceClient = m::mock(GuzzleClient::class);

        $middlewareFactory->shouldReceive('getConfiguration')->andReturn($configuration);
        $factory->shouldReceive('getMiddlewareFactory')->andReturn($middlewareFactory);
        $configuration->shouldReceive('setAuthCode')->withArgs(['asdfg']);
        $stateStore->shouldReceive('get')->andReturn('12345');
        $factory->shouldReceive('create')->andReturn($client);
        $client->shouldReceive('account')->andReturn($serviceClient);
        $serviceClient->shouldReceive('getResourceOwner');

        $code = 'asdfg';
        $state = '12345';

        $authorizer = new ClientAuthorizer($oauthProvider, $tokenStore, $stateStore, $redirector, $factory);
        $owner = $authorizer->authorizeClient($code, $state);
    }

}