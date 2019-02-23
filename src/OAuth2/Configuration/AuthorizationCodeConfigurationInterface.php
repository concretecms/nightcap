<?php
namespace Concrete\Api\Client\OAuth2\Configuration;

interface AuthorizationCodeConfigurationInterface extends ClientCredentialsConfigurationInterface
{

    public function getAuthCode();

    public function getRedirectUri();


}