<?php

namespace JG\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('JGFrontBundle:Default:index.html.twig');
    }
}
