<?php
namespace Concrete\Nightcap\OAuth2\Middleware;

use Concrete\Nightcap\OAuth2\Configuration\ConfigurationInterface;
use Concrete\Nightcap\OAuth2\Middleware\Client\AuthorizationClientFactory;
use Concrete\Nightcap\OAuth2\Middleware\GrantType\GrantTypeInterface;
use kamermans\OAuth2\GrantType\RefreshToken;
use kamermans\OAuth2\OAuth2Middleware;
use kamermans\OAuth2\Persistence\TokenPersistenceInterface;

class MiddlewareFactory implements MiddlewareFactoryInterface
{

    /**
     * @var ConfigurationInterface
     */
    protected $configuration;

    /**
     * @var GrantTypeInterface
     */
    protected $grantType;

    /**
     * @var TokenPersistenceInterface
     */
    protected $tokenPersistence;

    /**
     * @var AuthorizationClientFactory
     */
    protected $clientFactory;

    public function __construct(
        ConfigurationInterface $configuration,
        GrantTypeInterface $grantType,
        AuthorizationClientFactory $clientFactory,
        TokenPersistenceInterface $tokenPersistence)
    {
        $this->configuration = $configuration;
        $this->clientFactory = $clientFactory;
        $this->grantType = $grantType;
        $this->tokenPersistence = $tokenPersistence;
    }

    /**
     * @return TokenPersistenceInterface
     */
    public function getTokenPersistence()
    {
        return $this->tokenPersistence;
    }

    /**
     * @return ConfigurationInterface
     */
    public function getConfiguration()
    {
        return $this->configuration;
    }

    public function create()
    {
        $reauthClient = $this->clientFactory->createClient($this->configuration);
        $baseGrant = $this->grantType->createMiddlewareGrantType($reauthClient, $this->configuration);
        $refreshGrant = $this->grantType->createMiddlewareRefreshToken($reauthClient, $this->configuration);
        $oauth = new OAuth2Middleware($baseGrant, $refreshGrant);
        $oauth->setTokenPersistence($this->tokenPersistence);
        return $oauth;
    }

}