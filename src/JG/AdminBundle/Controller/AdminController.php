<?php

namespace JG\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    public function indexAction()
    {
        return $this->render('JGAdminBundle:Admin:index.html.twig');
    }
}
