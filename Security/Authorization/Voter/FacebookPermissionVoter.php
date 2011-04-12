<?php

namespace Caefer\FacebookCanvasAppBundle\Security\Authorization\Voter;

use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Authorization\Voter\RoleVoter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class FacebookPermissionVoter extends RoleVoter
{
    public function __construct($prefix = 'FACEBOOK_PERMISSION_')
    {
        parent::__construct($prefix);
    }

    public function vote(TokenInterface $token, $object, array $attributes)
    {
        $result = VoterInterface::ACCESS_ABSTAIN;
        $roles = $this->extractRoles($token);

        foreach ($attributes as $attribute) {
            if ($this->supportsAttribute($attribute)) {
                $result = VoterInterface::ACCESS_GRANTED;
                break;
            }
        }

        if (0 != count($this->getNotGrantedPermissions($token, $attributes))) {
            $result = VoterInterface::ACCESS_DENIED;
        }

        return $result;
    }

    public function getNotGrantedPermissions(TokenInterface $token, array $attributes)
    {
        $roles = $this->extractRoles($token);
        foreach ($roles as $i => $role) {
            $roles[$i] = $role->getRole();
        }

        $diff = array_diff($attributes, $roles);
        foreach ($diff as $key => $role) {
            if (!$this->supportsAttribute($role)) {
                unset($diff[$key]);
            }
        }

        return $diff;
    }
}
