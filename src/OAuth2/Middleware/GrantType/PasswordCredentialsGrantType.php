<?php
namespace Concrete\Nightcap\OAuth2\Middleware\GrantType;

use Concrete\Nightcap\OAuth2\Configuration\ConfigurationInterface;
use Concrete\Nightcap\OAuth2\Configuration\PasswordCredentialsConfigurationInterface;
use GuzzleHttp\Client;
use kamermans\OAuth2\GrantType\ClientCredentials;
use kamermans\OAuth2\GrantType\PasswordCredentials;

class PasswordCredentialsGrantType implements GrantTypeInterface
{

    protected function getConfig(ConfigurationInterface $configuration)
    {
        return [
            'client_id' => $configuration->getClientId(),
            'client_secret' => $configuration->getClientSecret(),
            'username' => $configuration->getUsername(),
            'password' => $configuration->getPassword(),
            'scope' => implode(' ', $configuration->getScopes()),
        ];
    }

    public function createMiddlewareGrantType(Client $client, ConfigurationInterface $configuration)
    {
        return new PasswordCredentials($client, $this->getConfig($configuration));
    }

    public function createMiddlewareRefreshToken(Client $client, ConfigurationInterface $configuration)
    {
        return null;
    }


}



