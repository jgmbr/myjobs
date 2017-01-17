<?php

namespace JG\FrontBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
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

    /**
     * Notification Alert Manager
     *
     * @Route("/notification/alert", name="alert_notif")
     * @Method({"GET", "POST"})
     */
    public function notifAction(Request $request)
    {
        $notificationAlert = $this->get('app.alert');

        $notificationAlert->alert();

        die('notification alert OK');
    }
}
