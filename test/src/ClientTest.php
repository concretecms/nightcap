<?php

namespace Concrete\Api\Client\Test;

use Concrete\Api\Client\Client;
use Concrete\Api\Client\Service\Description\SystemDescription;
use Concrete\Api\Client\Service\ServiceCollection;
use Concrete\Api\Client\ServiceClientFactory;
use Concrete\OAuth2\Client\Provider\Concrete5;
use Mockery as m;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class ClientTest extends TestCase
{

    use m\Adapter\Phpunit\MockeryPHPUnitIntegration;

    public function testAddSystemDescription()
    {
        $systemDescription = new SystemDescription();
        $systemDescriptionDescription = $systemDescription->getDescription();
        $serviceClientFactory = m::mock(ServiceClientFactory::class);
        $serviceCollection = m::mock(ServiceCollection::class);

        $httpClient = m::mock('\GuzzleHttp\Client');
        $service = m::mock(SystemDescription::class);
        $service->shouldReceive('getNamespace')->andReturn('system');
        $service->shouldReceive('getDescription')->andReturn($systemDescriptionDescription);
        $serviceCollection->shouldReceive('add')->withArgs(['system', $service]);
        $serviceCollection->shouldReceive('toArray')->andReturn([$service]);

        $client = new Client($httpClient, $serviceCollection, $serviceClientFactory);
        $client->addServiceDescription($service);
        $descriptions = $client->getServiceDescriptions();
        $this->assertCount(1, $descriptions);
        $this->assertEquals($service, $descriptions[0]);
    }

    /*
    public function testGetSystemInformationMethod()
    {
        $client = m::mock(Client::class);
        $client->system()->getSystemInformation());
    }
    */
}