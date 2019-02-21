<?php

namespace Concrete\Api\Client\Provider;

use Concrete\Api\Client\OAuth2\NativeSessionAuthorizationStateStore;
use Concrete\Api\Client\Service\AccountDescription;
use Concrete\Api\Client\Service\SiteDescription;
use Concrete\Api\Client\Service\SystemDescription;
use Concrete\OAuth2\Client\Provider\Concrete5;
use kamermans\OAuth2\Persistence\TokenPersistenceInterface;

/**
 * Given a URL to a concrete5 site, the basic provider will let you instantiate a client.
 * Class BasicProvider
 * @package Concrete\Api\Client\Provider
 */
class Provider implements ProviderInterface
{

    /**
     * Client ID of the API integration.
     * @var string
     */
    protected $clientId;

    /**
     * Client Secret of the API integration
     * @var string
     */
    protected $clientSecret;

    /**
     * The base URL of the concrete5 site.
     * @var
     */
    protected $baseUrl;

    /**
     * The URL on the authorizing client site to callback to.
     * @var string
     */
    protected $redirectUri;

    /**
     * Additional config options to pass
     * @var array
     */
    protected $config = [];

    /**
     * @var TokenPersistenceInterface
     */
    protected $tokenStore;

    public function __construct(
        $clientId,
        $clientSecret,
        $baseUrl,
        $redirectUri,
        TokenPersistenceInterface $store,
        $config = [])
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->baseUrl = $baseUrl;
        $this->redirectUri = $redirectUri;
        $this->config = $config;
        $this->tokenStore = $store;
    }

    public function getAdditionalServiceDescriptions()
    {
        return [];
    }

    /**
     * @return mixed
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    /**
     * @return array
     */
    public function getClientConfig(): array
    {
        return $this->config;
    }

    public function createAuthenticationProvider()
    {
        return new Concrete5([
            'clientId' => $this->clientId,
            'clientSecret' => $this->clientSecret,
            'redirectUri' => $this->redirectUri,
            'baseUrl' => $this->baseUrl
        ]);
    }

    /**
     * @return string
     */
    public function getClientId(): string
    {
        return $this->clientId;
    }

    /**
     * @return string
     */
    public function getClientSecret(): string
    {
        return $this->clientSecret;
    }

    /**
     * @return string
     */
    public function getRedirectUri(): string
    {
        return $this->redirectUri;
    }


    public function getServiceDescriptions()
    {
        $descriptions = [
            new AccountDescription(),
            new SystemDescription(),
            new SiteDescription()
        ];
        foreach ($this->getAdditionalServiceDescriptions() as $description) {
            $descriptions[] = $description;
        }
        return $descriptions;
    }

    public function getTokenStore()
    {
        return $this->tokenStore;
    }

    public function getAuthorizationStateStore()
    {
        return new NativeSessionAuthorizationStateStore();
    }

}