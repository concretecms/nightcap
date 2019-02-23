<?php
namespace Concrete\Api\Client\OAuth2\Configuration;

use Concrete\Api\Client\OAuth2\Configuration\Traits\ClientIdTrait;
use Concrete\Api\Client\OAuth2\Configuration\Traits\ScopesTrait;
use Concrete\Api\Client\OAuth2\Configuration\Traits\TokenEndpointTrait;
use Concrete\Api\Client\OAuth2\Configuration\Traits\BaseUrlTrait;

class ClientCredentialsConfiguration implements ClientCredentialsConfigurationInterface
{

    protected $baseUrl;

    protected $clientId;

    protected $clientSecret;

    protected $scopes = [];

    /**
     * @return mixed
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    /**
     * @param mixed $baseUrl
     */
    public function setBaseUrl($baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    /**
     * @return mixed
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * @param mixed $clientId
     */
    public function setClientId($clientId)
    {
        $this->clientId = $clientId;
    }

    /**
     * @return array
     */
    public function getScopes()
    {
        return $this->scopes;
    }

    /**
     * @param array $scopes
     */
    public function setScopes($scopes)
    {
        $this->scopes = $scopes;
    }



    /**
     * @return mixed
     */
    public function getClientSecret()
    {
        return $this->clientSecret;
    }

    /**
     * @param mixed $clientSecret
     */
    public function setClientSecret($clientSecret)
    {
        $this->clientSecret = $clientSecret;
    }

    

}