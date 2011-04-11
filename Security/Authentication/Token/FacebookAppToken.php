<?php

namespace Caefer\FacebookAppBundle\Security\Authentication\Token;

use Symfony\Component\Security\Core\Authentication\Token\AbstractToken;

class FacebookAppToken extends AbstractToken
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
