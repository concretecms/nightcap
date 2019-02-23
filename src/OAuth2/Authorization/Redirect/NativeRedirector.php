<?php
namespace Concrete\Api\Client\OAuth2\Authorization\Redirect;

class NativeRedirector implements RedirectorInterface
{

    public function redirect($authorizationUrl)
    {
        header('Location: ' . $authorizationUrl);
        exit;
    }
}