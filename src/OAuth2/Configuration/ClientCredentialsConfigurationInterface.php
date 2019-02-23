<?php
namespace Concrete\Api\Client\OAuth2\Configuration;

interface ClientCredentialsConfigurationInterface extends ConfigurationInterface
{

    public function getClientSecret();

}