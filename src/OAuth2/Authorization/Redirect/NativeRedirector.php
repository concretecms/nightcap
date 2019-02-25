<?php
namespace Concrete\Nightcap\OAuth2\Authorization\Redirect;

class NativeRedirector implements RedirectorInterface
{

    public function redirect($authorizationUrl)
    {
        header('Location: ' . $authorizationUrl);
        exit;
    }
}