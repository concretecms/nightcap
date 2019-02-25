<?php
namespace Concrete\Nightcap\OAuth2\Middleware\GrantType;

use Concrete\Nightcap\OAuth2\Configuration\ConfigurationInterface;
use GuzzleHttp\Client;
use kamermans\OAuth2\GrantType\RefreshToken;

interface GrantTypeInterface
{

    /**
     * @param Client $client
     * @param ConfigurationInterface $configuration
     * @return \kamermans\OAuth2\GrantType\GrantTypeInterface
     */
    public function createMiddlewareGrantType(Client $client, ConfigurationInterface $configuration);

    /**
     * @param Client $client
     * @param ConfigurationInterface $configuration
     * @return RefreshToken|null
     */
    public function createMiddlewareRefreshToken(Client $client, ConfigurationInterface $configuration);

}