<?php
namespace Concrete\Api\Client\OAuth2\Middleware;

use Concrete\Api\Client\OAuth2\Configuration\ConfigurationInterface;
use Concrete\Api\Client\OAuth2\Middleware\Client\AuthorizationClientFactory;
use Concrete\Api\Client\OAuth2\Middleware\GrantType\GrantTypeInterface;
use kamermans\OAuth2\GrantType\RefreshToken;
use kamermans\OAuth2\OAuth2Middleware;
use kamermans\OAuth2\Persistence\TokenPersistenceInterface;

interface MiddlewareFactoryInterface
{

    /**
     * @return TokenPersistenceInterface
     */
    public function getTokenPersistence();

    /**
     * @return ConfigurationInterface
     */
    public function getConfiguration();

    /**
     * @return OAuth2Middleware
     */
    public function create();

}