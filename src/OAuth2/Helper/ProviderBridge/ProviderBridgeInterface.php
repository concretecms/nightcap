<?php
namespace Concrete\Api\Client\OAuth2\Helper\ProviderBridge;

use Concrete\Api\Client\OAuth2\Configuration\ConfigurationInterface;

interface ProviderBridgeInterface
{

    public static function createProvider(ConfigurationInterface $configuration);


}