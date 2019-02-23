<?php
namespace Concrete\Api\Client\OAuth2\Configuration;

interface PasswordCredentialsConfigurationInterface extends ConfigurationInterface
{

    public function getUsername();

    public function getPassword();
}