<?php
namespace Concrete\Nightcap\OAuth2\Configuration;

interface PasswordCredentialsConfigurationInterface extends ConfigurationInterface
{

    public function getUsername();

    public function getPassword();
}