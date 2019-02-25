<?php
namespace Concrete\Nightcap\OAuth2\Helper\ProviderBridge;

use Concrete\Nightcap\OAuth2\Configuration\ConfigurationInterface;

interface ProviderBridgeInterface
{

    public static function createProvider(ConfigurationInterface $configuration);


}