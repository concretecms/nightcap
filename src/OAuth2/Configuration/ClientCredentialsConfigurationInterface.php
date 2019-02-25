<?php
namespace Concrete\Nightcap\OAuth2\Configuration;

interface ClientCredentialsConfigurationInterface extends ConfigurationInterface
{

    public function getClientSecret();

}