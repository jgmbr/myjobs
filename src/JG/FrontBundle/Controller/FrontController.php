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
            $contact->setViewed(false);
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

    public function cookiesAction()
    {
        return $this->render('JGFrontBundle:Front:cookies.html.twig');
    }

    /**
     * @Route("/pageError", name="page_error")
     */
    public function pageErrorAction()
    {
        return $this->render('JGFrontBundle:Front:pageError.html.twig');
    }

    /**
     * @Route("/page404", name="page_404")
     */
    public function page404Action()
    {
        return $this->render('JGFrontBundle:Front:page404.html.twig');
    }

    /**
     * @Route("/page500", name="page_500")
     */
    public function page500Action()
    {
        return $this->render('JGFrontBundle:Front:page500.html.twig');
    }

    /**
     * Notification Alert Manager Applications
     *
     * @Route("/notification/alert", name="alert_notif_applications")
     * @Method({"GET", "POST"})
     */
    public function notifApplicationsAction(Request $request)
    {
        $notificationAlert = $this->get('app.alert.application');

        $notificationAlert->alert();

        die('notification applications alert OK');
    }

    /**
     * Notification Alert Manager Appointments
     *
     * @Route("/notification/appointment", name="alert_notif_appointments")
     * @Method({"GET", "POST"})
     */
    public function notifAppointmentsAction(Request $request)
    {
        $notificationAlert = $this->get('app.alert.appointment');

        $notificationAlert->alert();

        die('notification appointments alert OK');
    }

    /**
     * Purger CSV
     *
     * @Route("/purger/csv", name="purger_csv")
     * @Method({"GET", "POST"})
     */
    public function purgerCSVAction(Request $request)
    {
        $purger = $this->get('app.purger');

        $purger->purgeCSV();

        die('purge CSV OK');
    }

    /**
     * Purger ZIP
     *
     * @Route("/purger/zip", name="purger_zip")
     * @Method({"GET", "POST"})
     */
    public function purgerZIPAction(Request $request)
    {
        $purger = $this->get('app.purger');

        $purger->purgeZIP();

        die('purge ZIP OK');
    }
}
