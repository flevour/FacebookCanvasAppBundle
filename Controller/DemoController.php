<?php

namespace Caefer\FacebookCanvasAppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DemoController extends Controller
{
    public function indexAction()
    {
        return $this->render('CaeferFacebookCanvasAppBundle:Demo:index.html.twig');
    }

    public function secure1Action()
    {
        return $this->render('CaeferFacebookCanvasAppBundle:Demo:secure1.html.twig');
    }

    public function secure2Action()
    {
        return $this->render('CaeferFacebookCanvasAppBundle:Demo:secure2.html.twig');
    }
}
