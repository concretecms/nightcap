<?php

namespace Concrete\Api\Client\Test;

use Concrete\Api\Client\Client;
use Concrete\Api\Client\Service\Description\SystemDescription;
use Concrete\Api\Client\Service\ServiceCollection;
use Concrete\Api\Client\Service\ServiceDescriptionFactory;
use Concrete\Api\Client\ServiceClientFactory;
use Concrete\OAuth2\Client\Provider\Concrete5;
use GuzzleHttp\Command\Guzzle\Description;
use Mockery as m;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class ClientTest extends TestCase
{

    use m\Adapter\Phpunit\MockeryPHPUnitIntegration;

    public function testAddServiceDescription()
    {
        $systemDescription = new SystemDescription();
        $systemDescriptionDescription = $systemDescription->getDescription();
        $serviceClientFactory = m::mock(ServiceClientFactory::class);
        $serviceDescriptionFactory = m::mock(ServiceDescriptionFactory::class);
        $serviceCollection = m::mock(ServiceCollection::class);

        $httpClient = m::mock('\GuzzleHttp\Client');
        $service = m::mock(SystemDescription::class);
        $service->shouldReceive('getNamespace')->andReturn('system');
        $service->shouldReceive('getDescription')->andReturn($systemDescriptionDescription);
        $serviceCollection->shouldReceive('add')->withArgs(['system', $service]);
        $serviceCollection->shouldReceive('toArray')->andReturn([$service]);

        $client = new Client($httpClient, $serviceCollection, $serviceClientFactory, $serviceDescriptionFactory);
        $client->addServiceDescription($service);
        $descriptions = $client->getServiceDescriptions();
        $this->assertCount(1, $descriptions);
        $this->assertEquals($service, $descriptions[0]);
    }

    public function testCustomServiceDescription()
    {
        $mockServiceDescription = m::mock(Description::class);
        $serviceDescriptionFactory = m::mock(ServiceDescriptionFactory::class);
        $fooServiceDescription = m::mock(SystemDescription::class);
        $fooServiceDescriptionDescription = [
            'operations' => [
                'getFoo' => [
                    'httpMethod' => 'POST',
                    'uri' => '/ccm/api/v1/foo',
                    'responseModel' => 'fooResponse',
                    'parameters' => []
                ]
            ],
            'models' => [
                'fooResponse' => [
                    'type' => 'object',
                    'additionalProperties' => [
                        'location' => 'json'
                    ]
                ]
            ]

        ];
        $fooServiceDescription->shouldReceive('getDescription')->andReturn($fooServiceDescriptionDescription);
        $httpClient = m::mock('\GuzzleHttp\Client');
        $serviceCollection = m::mock(ServiceCollection::class);
        $serviceClientFactory = m::mock(ServiceClientFactory::class);
        $serviceCollection->shouldReceive('get')->andReturn($fooServiceDescription);
        $httpClient->shouldReceive('getConfig')->withArgs(['base_uri'])->andReturn('http://myconcrete5site.com');
        $fooServiceDescriptionDescription['baseUrl'] = 'http://myconcrete5site.com';
        $serviceDescriptionFactory->shouldReceive('createServiceDescription')->andReturn($mockServiceDescription);
        $serviceClientFactory->shouldReceive('createServiceClient')->withArgs([$httpClient, $mockServiceDescription]);
        $client = new Client($httpClient, $serviceCollection, $serviceClientFactory, $serviceDescriptionFactory);
        $serviceClient = $client->foo();
    }
    /*
    public function testGetSystemInformationMethod()
    {
        $client = m::mock(Client::class);
        $client->system()->getSystemInformation());
    }
    */
}