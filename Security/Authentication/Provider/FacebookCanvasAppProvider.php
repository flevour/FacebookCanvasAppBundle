<?php

namespace Caefer\FacebookCanvasAppBundle\Security\Authentication\Provider;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Provider\AuthenticationProviderInterface;

use Caefer\FacebookCanvasAppBundle\Security\Authentication\Token\FacebookCanvasAppToken;
use \Facebook;

class FacebookCanvasAppProvider implements AuthenticationProviderInterface
{
    /**
     * @var \Facebook
     */
    protected $facebook;
    protected $userProvider;
    protected $userChecker;

    public function __construct(Facebook $facebook, UserProviderInterface $userProvider = null, UserCheckerInterface $userChecker = null)
    {
        if (null !== $userProvider && null === $userChecker) {
            throw new \InvalidArgumentException('$userChecker cannot be null, if $userProvider is not null.');
        }

        $this->facebook = $facebook;
        $this->userProvider = $userProvider;
        $this->userChecker = $userChecker;
    }

    public function authenticate(TokenInterface $token)
    {
        if (!$this->supports($token)) {
            return null;
        }

        try {
            if ($uid = $this->facebook->getUser()) {
                return $this->createAuthenticatedToken($uid);
            }
        } catch (AuthenticationException $failed) {
            throw $failed;
        } catch (\Exception $failed) {
            throw new AuthenticationException('Unknown error', $failed->getMessage(), $failed->getCode(), $failed);
        }

        throw new AuthenticationException('The Facebook user could not be retrieved from the session.');
    }

    public function supports(TokenInterface $token)
    {
        return true;
    }

    protected function createAuthenticatedToken($uid)
    {
        if (null === $this->userProvider) {

            return new FacebookCanvasAppToken($uid, $this->getFacebookPermissionsAsRoles($uid));
        }
    }

    private function getFacebookPermissionsAsRoles($uid)
    {
        $roles = array();

        try {
            $permissionLists = $this->facebook->api(array(
                'method' => 'fql.multiquery',
                'queries' => array(
                    'user' => 'SELECT user_about_me,user_activities,user_birthday,user_education_history,user_events,user_groups,user_hometown,user_interests,user_likes,user_location,user_notes,user_online_presence,user_photo_video_tags,user_photos,user_relationships,user_relationship_details,user_religion_politics,user_status,user_videos,user_website,user_work_history,email,read_friendlists,read_insights,read_mailbox,read_requests,read_stream,xmpp_login,ads_management,user_checkins FROM permissions WHERE uid = '.$uid,
                    'friends' => 'SELECT friends_about_me,friends_activities,friends_birthday,friends_education_history,friends_events,friends_groups,friends_hometown,friends_interests,friends_likes,friends_location,friends_notes,friends_online_presence,friends_photo_video_tags,friends_photos,friends_relationships,friends_relationship_details,friends_religion_politics,friends_status,friends_videos,friends_website,friends_work_history,manage_friendlists,friends_checkins FROM permissions WHERE uid = '.$uid,
                    'extended' => 'SELECT publish_stream,create_event,rsvp_event,sms,offline_access,publish_checkins,manage_pages FROM permissions WHERE uid = '.$uid
                )
            ));
        } catch(\Exception $e) {
            return $roles;
        }

        foreach ($permissionLists as $permissionList) {
            foreach ($permissionList['fql_result_set'][0] as $perm => $set) {
                if (1 == $set) {
                    $roles[] = strtoupper('FACEBOOK_PERMISSION_'.$perm);
                }
            }
        }

        return $roles;
    }
}
