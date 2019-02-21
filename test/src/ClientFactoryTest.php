<?php

namespace Concrete\Api\Client\Test;

use Concrete\Api\Client\Client;
use Concrete\Api\Client\ClientFactory;
use Concrete\Api\Client\OAuth2\AuthorizationStateStoreInterface;
use Concrete\Api\Client\OAuth2\Exception\InvalidStateException;
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
use kamermans\OAuth2\Persistence\TokenPersistenceInterface;
use kamermans\OAuth2\Token\RawToken;
use Mockery as m;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class ClientFactoryTest extends TestCase
{

    use m\Adapter\Phpunit\MockeryPHPUnitIntegration;

    protected function getFactoryAndProvider()
    {
        $accountDescription = new AccountDescription();
        $accountDescriptionDescription = $accountDescription->getDescription();

        $serviceCollection = m::mock(ServiceCollection::class);
        $serviceClientFactory = m::mock(ServiceClientFactory::class);
        $serviceDescriptionFactory = m::mock(ServiceDescriptionFactory::class);
        $serviceClient = m::mock(GuzzleClient::class);
        $logger = m::mock(LoggerInterface::class);
        $provider = m::mock(ProviderInterface::class);
        $tokenStore = m::mock(TokenPersistenceInterface::class);
        $concrete5 = m::mock(Concrete5::class);
        $mockAccountDescription = m::mock(AccountDescription::class);
        $rawToken = m::mock(RawToken::class);
        $serviceDescription = m::mock(Description::class);

        $serviceDescriptionFactory->shouldReceive('createServiceDescription')->andReturn($serviceDescription);
        $serviceClientFactory->shouldReceive('createServiceClient')->andReturn($serviceClient);
        $logger->shouldReceive('notice')->withArgs(['/api/fart'])->andReturnNull();
        $logger->shouldReceive('log')->andReturnNull();
        $rawToken->shouldReceive('isExpired')->andReturn(false);
        $rawToken->shouldReceive('getAccessToken')->andReturn('mockaccesstoken');
        $mockAccountDescription->shouldReceive('getNamespace')->andReturn('account');
        $mockAccountDescription->shouldReceive('getDescription')->andReturn($accountDescriptionDescription);
        $serviceCollection->shouldReceive('add')->withArgs(['account', $mockAccountDescription]);
        $serviceCollection->shouldReceive('get')->andReturn($mockAccountDescription);

        $descriptions = [$mockAccountDescription];

        $tokenStore->shouldReceive('restoreToken')->andReturn($rawToken);
        $concrete5->shouldReceive('getBaseAccessTokenUrl')->andReturn('http://api.test.com/token');
        $concrete5->shouldReceive('getClientId')->andReturn('xyz');
        $concrete5->shouldReceive('getClientSecret')->andReturn('abbadabba');
        $provider->shouldReceive('createAuthenticationProvider')->andReturn($concrete5);
        $provider->shouldReceive('getClientId')->andReturn('xyz');
        $provider->shouldReceive('getClientSecret')->andReturn('abbadabba');
        $provider->shouldReceive('getRedirectUri')->andReturn('http://api.test.com/redirect');
        $provider->shouldReceive('getTokenStore')->andReturn($tokenStore);
        $provider->shouldReceive('getBaseUrl')->andReturn('http://api.test.com');
        $provider->shouldReceive('getServiceDescriptions')->andReturn($descriptions);

        $factory = new ClientFactory($serviceClientFactory, $serviceDescriptionFactory, $serviceCollection, $logger);
        return [$factory, $provider, $serviceClient];
    }

    public function testCreateClient()
    {
        list($factory, $provider, $serviceClient) = $this->getFactoryAndProvider();
        $client = $factory->create($provider);
        $this->assertInstanceOf(Client::class, $client);

        $webServiceClient = $client->account();
        $this->assertInstanceOf(GuzzleClient::class, $webServiceClient);
    }

    /**
     * @expectedException \Concrete\Api\Client\OAuth2\Exception\InvalidStateException
     */
    public function testAuthorizeClientFailure()
    {
        $authorizationStateStore = m::mock(AuthorizationStateStoreInterface::class);
        $authorizationStateStore->shouldReceive('get')->andReturn('12345doesnotmatch');
        list($factory, $provider, $serviceClient) = $this->getFactoryAndProvider();
        $provider->shouldReceive('getAuthorizationStateStore')->andReturn($authorizationStateStore);
        $code = 'asdfg';
        $state = '12345';
        $owner = $factory->authorizeClient($provider, $code, $state);
    }

    public function testAuthorizeClientSuccess()
    {
        $authorizationStateStore = m::mock(AuthorizationStateStoreInterface::class);
        $authorizationStateStore->shouldReceive('get')->andReturn('12345');
        list($factory, $provider, $serviceClient) = $this->getFactoryAndProvider();
        $provider->shouldReceive('getAuthorizationStateStore')->andReturn($authorizationStateStore);
        $code = 'asdfg';
        $state = '12345';
        $serviceClient->shouldReceive('getResourceOwner');
        $owner = $factory->authorizeClient($provider, $code, $state);
    }



}