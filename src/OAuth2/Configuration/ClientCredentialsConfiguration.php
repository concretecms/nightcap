<?php
namespace Concrete\Api\Client\OAuth2\Configuration;

use Concrete\Api\Client\OAuth2\Configuration\Traits\ClientIdTrait;
use Concrete\Api\Client\OAuth2\Configuration\Traits\ScopesTrait;
use Concrete\Api\Client\OAuth2\Configuration\Traits\TokenEndpointTrait;
use Concrete\Api\Client\OAuth2\Configuration\Traits\BaseUrlTrait;

class ClientCredentialsConfiguration implements ClientCredentialsConfigurationInterface
{

    use ClientIdTrait;
    use BaseUrlTrait;
    use ScopesTrait;

    protected $clientSecret;

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