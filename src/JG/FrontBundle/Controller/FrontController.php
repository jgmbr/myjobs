<?php

namespace JG\FrontBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FrontController extends Controller
{
    /**
     * @Route("/", name="home_page")
     */
    public function indexAction()
    {
        $user = $this->getUser();
  
        if ($user) {
            if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
                var_dump('IS ADMIN');
            } else {
                var_dump('NOT ADMIN');
            }
        }

        return $this->render('JGFrontBundle:Front:index.html.twig');
    }

    /**
     * @Route("/contact", name="contact_page")
     */
    public function contactAction()
    {
        return $this->render('JGFrontBundle:Front:contact.html.twig');
    }

    /**
     * @Route("/mentions-legales", name="mentions_page")
     */
    public function mentionsAction()
    {
        return $this->render('JGFrontBundle:Front:mentions.html.twig');
    }

}
