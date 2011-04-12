<?php

namespace Caefer\FacebookCanvasAppBundle\Security\Firewall;

use Symfony\Component\Security\Http\Firewall\AbstractAuthenticationListener;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Session\SessionAuthenticationStrategyInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface;
use Symfony\Component\HttpKernel\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Caefer\FacebookCanvasAppBundle\Security\Authentication\Token\FacebookCanvasAppToken;

/**
 * Facebook authentication listener.
 */
class FacebookCanvasAppListener extends AbstractAuthenticationListener
{
    public function __construct(SecurityContextInterface $securityContext, AuthenticationManagerInterface $authenticationManager, SessionAuthenticationStrategyInterface $sessionStrategy, $providerKey, array $options = array(), AuthenticationSuccessHandlerInterface $successHandler = null, AuthenticationFailureHandlerInterface $failureHandler = null, LoggerInterface $logger = null, EventDispatcherInterface $dispatcher = null)
    {
        $options['use_referer'] = $options['use_referer'] ?: true;
        parent::__construct($securityContext, $authenticationManager, $sessionStrategy, $providerKey, $options, $successHandler, $failureHandler, $logger, $dispatcher);
    }

    protected function attemptAuthentication(Request $request)
    {
        if (null === $token = $this->authenticationManager->authenticate(new FacebookCanvasAppToken())) {
            return null;
        }

        return $token;
    }
}
