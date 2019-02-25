<?php
namespace Concrete\Nightcap\OAuth2\Configuration;

use Concrete\Nightcap\OAuth2\Configuration\Traits\ClientIdTrait;
use Concrete\Nightcap\OAuth2\Configuration\Traits\ScopesTrait;
use Concrete\Nightcap\OAuth2\Configuration\Traits\TokenEndpointTrait;
use Concrete\Nightcap\OAuth2\Configuration\Traits\BaseUrlTrait;

class PasswordCredentialsConfiguration extends ClientCredentialsConfiguration
    implements PasswordCredentialsConfigurationInterface
{

    protected $username;

    protected $password;

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }



}