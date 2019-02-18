<?php
namespace Concrete\Api\Client\OAuth2\Provider\Factory;

use Concrete\OAuth2\Client\Provider\Concrete5;

interface ProviderFactoryInterface
{

    /**
     * @return Concrete5
     */
    public function createProvider();
}