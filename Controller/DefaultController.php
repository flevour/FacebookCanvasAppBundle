<?php

namespace Caefer\FacebookAppBundle\Controller;

require_once __DIR__.'/../../../../vendor/facebook/src/facebook.php';

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('CaeferFacebookAppBundle:Default:index.html.twig');
    }

    public function authAction($perms, $success = '')
    {
        $fb = $this->container->get('caefer_facebookapp.api');
        $perms = explode(',',$perms);
        return $this->render('CaeferFacebookAppBundle:Default:auth.html.twig', array('app_id' => $fb->getAppId(), 'session' => json_encode($fb->getSession()), 'perms' => $perms));
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
