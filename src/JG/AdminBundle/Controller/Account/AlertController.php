<?php

namespace JG\AdminBundle\Controller\Account;

use JG\CoreBundle\Entity\Alert;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Alert controller.
 *
 * @Route("alert")
 */
class AlertController extends Controller
{
    /**
     * Lists all alert entities.
     *
     * @Route("/", name="alert_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();

        $listAlerts = $em->getRepository('JGCoreBundle:Alert')->findMyAlerts($user);

        return $this->render('JGAdminBundle:Account:alert/index.html.twig', array(
            'alerts' => $listAlerts
        ));
    }

    /**
     * Moderation choice alert.
     *
     * @Route("/moderate/{id}/state/{state}", name="alert_valid")
     * @Method("GET")
     */
    public function validAction(Request $request, Alert $alert, $state)
    {
        $em = $this->getDoctrine()->getManager();

        $alert->setViewed($state);

        $em->persist($alert);

        $em->flush($alert);

        $request->getSession()->getFlashBag()->add('success', 'Alerte validée avec succès !');

        return $this->redirectToRoute('alert_index');
    }
}
