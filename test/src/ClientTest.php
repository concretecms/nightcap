<?php

namespace Concrete\Api\Client\Test;

use Concrete\Api\Client\Client;
use Concrete\OAuth2\Client\Provider\Concrete5;
use Mockery as m;
use ReflectionClass;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    protected $provider;

    public function testCreateClient()
    {
        $client = m::mock(Client::class);
        $this->assertInstanceOf(Client::class, $client);
    }
}