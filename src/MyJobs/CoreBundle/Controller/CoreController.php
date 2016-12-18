<?php

namespace MyJobs\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CoreController extends Controller
{
    public function indexAction()
    {
        return $this->render('MyJobsCoreBundle:Core:index.html.twig');
    }
}
