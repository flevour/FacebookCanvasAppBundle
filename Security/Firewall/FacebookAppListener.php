<?php

namespace Caefer\FacebookAppBundle\Security\Firewall;

use Caefer\FacebookAppBundle\Security\Authentication\Token\FacebookAppToken;
use Symfony\Component\Security\Http\Firewall\AbstractAuthenticationListener;

use Symfony\Component\HttpFoundation\Request;

/**
 * Facebook authentication listener.
 */
class FacebookAppListener extends AbstractAuthenticationListener
{
    protected function attemptAuthentication(Request $request)
    {
        return $this->authenticationManager->authenticate(new FacebookAppToken());
    }
}
