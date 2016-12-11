<?php

namespace JG\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('JGCoreBundle:Default:index.html.twig');
    }
}
