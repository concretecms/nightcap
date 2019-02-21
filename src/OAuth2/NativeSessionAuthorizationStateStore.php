<?php
namespace Concrete\Api\Client\OAuth2;

class NativeSessionAuthorizationStateStore implements AuthorizationStateStoreInterface
{

    public function set($state)
    {
        $_SESSION['oauth2state'] = $state;
    }

    public function get()
    {
        return $_SESSION['oauth2state'];
    }

}