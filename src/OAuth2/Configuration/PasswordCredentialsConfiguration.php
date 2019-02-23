<?php
namespace Concrete\Api\Client\OAuth2\Configuration;

use Concrete\Api\Client\OAuth2\Configuration\Traits\ClientIdTrait;
use Concrete\Api\Client\OAuth2\Configuration\Traits\ScopesTrait;
use Concrete\Api\Client\OAuth2\Configuration\Traits\TokenEndpointTrait;
use Concrete\Api\Client\OAuth2\Configuration\Traits\BaseUrlTrait;

class PasswordCredentialsConfiguration implements PasswordCredentialsConfigurationInterface
{

    use ClientIdTrait;
    use BaseUrlTrait;
    use ScopesTrait;

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