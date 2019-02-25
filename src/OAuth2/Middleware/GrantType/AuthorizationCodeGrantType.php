<?php
namespace Concrete\Nightcap\OAuth2\Middleware\GrantType;

use Concrete\Nightcap\OAuth2\Configuration\ConfigurationInterface;
use GuzzleHttp\Client;
use kamermans\OAuth2\GrantType\AuthorizationCode;
use kamermans\OAuth2\GrantType\RefreshToken;

class AuthorizationCodeGrantType implements GrantTypeInterface
{

    protected function getConfig(ConfigurationInterface $configuration)
    {
        return [
            'client_id' => $configuration->getClientId(),
            'client_secret' => $configuration->getClientSecret(),
            'code' => $configuration->getAuthCode(),
            'redirect_uri' => $configuration->getRedirectUri(),
        ];
    }

    public function createMiddlewareGrantType(Client $client, ConfigurationInterface $configuration)
    {
        return new AuthorizationCode($client, $this->getConfig($configuration));
    }

    public function createMiddlewareRefreshToken(Client $client, ConfigurationInterface $configuration)
    {
        return new RefreshToken($client, $this->getConfig($configuration));
    }



}