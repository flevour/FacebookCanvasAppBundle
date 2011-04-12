<?php

namespace Caefer\FacebookCanvasAppBundle\Security\Authentication\Token;

use Symfony\Component\Security\Core\Authentication\Token\AbstractToken;

class FacebookCanvasAppToken extends AbstractToken
{
    public function __construct($uid = '', array $roles = array())
    {
        parent::__construct($roles);
    }

    public function getCredentials()
    {
      throw new \Exception();
        return '';
    }
}
