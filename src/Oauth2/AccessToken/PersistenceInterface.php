<?php
namespace Concrete\Api\Client\Provider;

use Concrete\OAuth2\Client\Provider\Concrete5;
use League\OAuth2\Client\Token\AccessTokenInterface;

interface ProviderInterface
{

    /**
     * @return string
     */
    public function getBaseUrl();

    /**
     * @return array
     */
    public function getClientConfig();


    /**
     * @return Concrete5
     */
    public function createOauthProvider();

}