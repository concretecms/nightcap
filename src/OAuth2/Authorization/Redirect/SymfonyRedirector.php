<?php
namespace Concrete\Nightcap\OAuth2\Authorization\Redirect;

use Symfony\Component\HttpFoundation\RedirectResponse;
class SymfonyRedirector implements RedirectorInterface
{

    public function redirect($authorizationUrl)
    {
        return new RedirectResponse($authorizationUrl);
    }
}