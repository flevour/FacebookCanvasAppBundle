<?php

namespace Caefer\FacebookAppBundle\Controller;

require_once __DIR__.'/../../../../vendor/facebook/src/facebook.php';

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function __construct()
    {
        $this->fb = new \Facebook(array(
            'appId'  => '123135494428911',
            'secret' => '606536e73b92ca0d90dcd4a849b9eb02',
            'cookie' => true
        ));
        $this->session = $this->fb->getSession();
    }

    public function indexAction()
    {
        return $this->render('CaeferFacebookAppBundle:Default:index.html.twig');
    }

    public function authAction($perms, $success = '')
    {
        $perms = explode(',',$perms);
        return $this->render('CaeferFacebookAppBundle:Default:auth.html.twig', array('app_id' => $this->fb->getAppId(), 'session' => json_encode($this->fb->getSession()), 'perms' => $perms));
    }

    public function secureAction()
    {
        return $this->render('CaeferFacebookAppBundle:Default:secure.html.twig');
    }

    public function anothersecureAction()
    {
        return $this->render('CaeferFacebookAppBundle:Default:anothersecure.html.twig');
    }
}
