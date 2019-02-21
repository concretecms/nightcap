<?php

namespace Concrete\Api\Client\Test;

use Concrete\Api\Client\Client;
use Concrete\Api\Client\Service\SystemDescription;
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

        $httpClient = m::mock('\GuzzleHttp\Client');
        $service = m::mock(SystemDescription::class);
        $service->shouldReceive('getNamespace')->andReturn('system');
        $service->shouldReceive('getDescription')->andReturn($systemDescriptionDescription);
        $client = new Client($httpClient);
        $client->addServiceDescription($service);
        $descriptions = $client->getServiceDescriptions();
        $this->assertCount(1, $descriptions);
        $this->assertEquals($systemDescriptionDescription, $descriptions['system']);
    }

    /*
    public function testGetSystemInformationMethod()
    {
        $client = m::mock(Client::class);
        $client->system()->getSystemInformation());
    }
    */
}