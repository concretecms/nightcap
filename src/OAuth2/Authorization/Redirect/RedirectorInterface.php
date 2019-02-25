<?php
namespace Concrete\Nightcap\OAuth2\Authorization\Redirect;

/**
 * Redirects to the authorization URL
 */
interface RedirectorInterface
{

    public function redirect($authorizationUrl);

}