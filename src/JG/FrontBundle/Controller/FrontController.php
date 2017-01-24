<?php

namespace JG\FrontBundle\Controller;

use JG\CoreBundle\Entity\Contact;
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
    public function indexAction(Request $request)
    {
        $contact = new Contact();
        $form = $this->createForm('JG\CoreBundle\Form\ContactType', $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush($contact);
            $request->getSession()->getFlashBag()->add('success', 'Demande de contact envoyée avec succès !');
            return $this->redirectToRoute('home_page');
        }

        return $this->render('JGFrontBundle:Front:index.html.twig', array(
            'contact' => $contact,
            'formContact' => $form->createView(),
        ));
    }

    /**
     * @Route("/contact", name="contact_page")
     */
    public function contactAction(Request $request)
    {
        $contact = new Contact();
        $form = $this->createForm('JG\CoreBundle\Form\ContactType', $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush($contact);
            $request->getSession()->getFlashBag()->add('success', 'Demande de contact envoyée avec succès !');
            return $this->redirectToRoute('home_page');
        }

        return $this->render('JGFrontBundle:Front:contact.html.twig', array(
            'contact' => $contact,
            'formContact' => $form->createView(),
        ));
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
        $notificationAlert = $this->get('app.alert.application');

        $notificationAlert->alert();

        die('notification alert OK');
    }
}
