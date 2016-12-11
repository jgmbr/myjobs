<?php

namespace JG\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('JGAdminBundle:Default:index.html.twig');
    }
}
