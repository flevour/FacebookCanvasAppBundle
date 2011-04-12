<?php

namespace Caefer\FacebookCanvasAppBundle\Controller;

require_once __DIR__.'/../../../../vendor/facebook/src/facebook.php';

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function authAction($perms, $success = '')
    {
        $fb = $this->container->get('caefer_facebook_canvas_app.api');
        $perms = explode(',',$perms);
        return $this->render('CaeferFacebookCanvasAppBundle:Default:auth.html.twig', array('app_id' => $fb->getAppId(), 'session' => json_encode($fb->getSession()), 'perms' => $perms));
    }
}
