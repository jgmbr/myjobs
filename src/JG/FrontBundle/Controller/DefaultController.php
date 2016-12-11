<?php

namespace JG\FrontBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="home_page")
     */
    public function indexAction()
    {
        return $this->render('JGFrontBundle:Default:index.html.twig');
    }

    /**
     * @Route("/login", name="login_page")
     */
    public function loginAction()
    {
        return $this->render('JGFrontBundle:Default:login.html.twig');
    }

    /**
     * @Route("/register", name="register_page")
     */
    public function registerAction()
    {
        return $this->render('JGFrontBundle:Default:register.html.twig');
    }

    /**
     * @Route("/reset", name="reset_page")
     */
    public function resetAction()
    {
        return $this->render('JGFrontBundle:Default:reset.html.twig');
    }

    /**
     * @Route("/contact", name="contact_page")
     */
    public function contactAction()
    {
        return $this->render('JGFrontBundle:Default:contact.html.twig');
    }
}
