<?php

namespace Caefer\FacebookAppBundle\Security\Authorization;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;
use Symfony\Component\Security\Http\AccessMap;
use Symfony\Component\Security\Core\SecurityContext;
use Caefer\FacebookAppBundle\Security\Authorization\Voter\FacebookPermissionVoter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\HttpKernel;

class FacebookPermissionNotGrantedHandler implements AccessDeniedHandlerInterface
{
    private $map;
    private $context;
    private $voter;
    private $container;

    public function __construct(AccessMap $map, SecurityContext $context, FacebookPermissionVoter $voter, HttpKernel $kernel)
    {
        $this->map = $map;
        $this->context = $context;
        $this->voter = $voter;
        $this->kernel = $kernel;
    }

    public function handle(Request $request, AccessDeniedException $accessDeniedException)
    {
      list($roles) = $this->map->getPatterns($request);
      if (0 == count($notGrantedPermissions = $this->voter->getNotGrantedPermissions($this->context->getToken(), $roles))) {
          throw $accessDeniedException;
      }

      array_walk($roles, function(&$e){$e = strtolower(str_replace('FACEBOOK_PERMISSION_', '', $e));});

      $params = array('perms' => implode(',', $roles), 'success' => $request->getRequestUri());
      return $this->kernel->forward('CaeferFacebookAppBundle:Default:auth', $params);
    }
}
