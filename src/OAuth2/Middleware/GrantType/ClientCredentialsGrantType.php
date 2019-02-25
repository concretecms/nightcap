<?php
namespace Concrete\Nightcap\OAuth2\Middleware\GrantType;

use Concrete\Nightcap\OAuth2\Configuration\ConfigurationInterface;
use GuzzleHttp\Client;
use kamermans\OAuth2\GrantType\ClientCredentials;

class ClientCredentialsGrantType implements GrantTypeInterface
{

    protected function getConfig(ConfigurationInterface $configuration)
    {
        return [
            'client_id' => $configuration->getClientId(),
            'client_secret' => $configuration->getClientSecret(),
            'scope' => implode(' ', $configuration->getScopes()),
        ];
    }

    public function createMiddlewareGrantType(Client $client, ConfigurationInterface $configuration)
    {
        return new ClientCredentials($client, $this->getConfig($configuration));
    }

    public function createMiddlewareRefreshToken(Client $client, ConfigurationInterface $configuration)
    {
        return null;
    }

}