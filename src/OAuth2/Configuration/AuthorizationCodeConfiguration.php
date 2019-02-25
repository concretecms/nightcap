<?php
namespace Concrete\Nightcap\OAuth2\Configuration;

use Concrete\Nightcap\OAuth2\Configuration\Traits\TokenEndpointTrait;

class AuthorizationCodeConfiguration extends ClientCredentialsConfiguration implements AuthorizationCodeConfigurationInterface
{

    protected $authCode;

    protected $redirectUri;

    /**
     * @return mixed
     */
    public function getAuthCode()
    {
        return $this->authCode;
    }

    /**
     * @param mixed $authCode
     */
    public function setAuthCode($authCode)
    {
        $this->authCode = $authCode;
    }

    /**
     * @return mixed
     */
    public function getRedirectUri()
    {
        return $this->redirectUri;
    }

    /**
     * @param mixed $redirectUri
     */
    public function setRedirectUri($redirectUri)
    {
        $this->redirectUri = $redirectUri;
    }


}