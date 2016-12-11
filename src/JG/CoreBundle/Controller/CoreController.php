<?php

namespace JG\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CoreController extends Controller
{
    public function indexAction()
    {
        return $this->render('JGCoreBundle:Core:index.html.twig');
    }
}
