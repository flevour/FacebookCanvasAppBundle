<?php

namespace Caefer\FacebookAppBundle\Security\EntryPoint;

use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Http\AccessMap;
use Symfony\Bundle\FrameworkBundle\HttpKernel;

/**
 * FacebookAuthenticationEntryPoint starts an authentication via Facebook.
 *
 * @author Thomas Adam <thomas.adam@tebot.de>
 */
class FacebookAppAuthenticationEntryPoint implements AuthenticationEntryPointInterface
{
    private $facebook;
    private $map;
    private $kernel;

    /**
     * Constructor
     *
     * @param Facebook $facebook
     * @param array    $options
     */
    public function __construct(\Facebook $facebook, array $options, AccessMap $map, HttpKernel $kernel)
    {
        $this->facebook = $facebook;
        $this->map = $map;
        $this->kernel = $kernel;
    }

    /**
     * {@inheritdoc}
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        list($roles) = $this->map->getPatterns($request);
        array_walk($roles, function(&$e){$e = strtolower(str_replace('FACEBOOK_PERMISSION_', '', $e));});

        $params = array('perms' => implode(',', $roles), 'success' => $request->getRequestUri());
        return $this->kernel->forward('CaeferFacebookAppBundle:Default:auth', $params);
    }
}
