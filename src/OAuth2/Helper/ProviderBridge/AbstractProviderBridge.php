<?php
namespace Concrete\Nightcap\OAuth2\Helper\ProviderBridge;

use Concrete\Nightcap\OAuth2\Configuration\AuthorizationCodeConfigurationInterface;
use Concrete\Nightcap\OAuth2\Configuration\ClientCredentialsConfigurationInterface;
use Concrete\Nightcap\OAuth2\Configuration\ConfigurationInterface;
use Concrete\Nightcap\OAuth2\Configuration\PasswordCredentialsConfigurationInterface;

/**
 * Converts the Configuration object into a other OAuth2 Providers
 */
abstract class AbstractProviderBridge implements ProviderBridgeInterface
{

    protected static function getConfig(ConfigurationInterface $configuration)
    {
        $config = [
            'clientId' => $configuration->getClientId(),
            'baseUrl' => $configuration->getBaseUrl(),
        ];
        if ($configuration instanceof ClientCredentialsConfigurationInterface) {
            $config['clientSecret'] = $configuration->getClientSecret();
        }
        if ($configuration instanceof PasswordCredentialsConfigurationInterface) {
            $config['username'] = $configuration->getUsername();
            $config['password'] = $configuration->getPassword();
        }
        if ($configuration instanceof AuthorizationCodeConfigurationInterface) {
            $config['redirectUri'] = $configuration->getRedirectUri();
        }
        return $config;
    }

}