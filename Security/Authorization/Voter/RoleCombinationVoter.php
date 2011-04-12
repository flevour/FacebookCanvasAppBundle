<?php

namespace Caefer\FacebookCanvasAppBundle\Security\Authorization\Voter;

use Symfony\Component\Security\Core\Authorization\Voter\RoleVoter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class FacebookPermissionVoter extends RoleVoter
{
    public function __construct($prefix = 'FB_')
    {
        parent::__construct($prefix);
    }

    public function vote(TokenInterface $token, $object, array $attributes)
    {
        echo '<h3>test me</h3>';
        echo '<pre>';
        print_r($token->getRoles());
        echo '</pre>';

        return parent::vote($token, $object, $attributes);
    }
}
