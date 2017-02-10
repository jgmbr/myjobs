<?php

namespace JG\AdminBundle\Controller\Account;

use Doctrine\DBAL\Types\BooleanType;
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

        $listAlerts = $em->getRepository(Alert::class)->findMyAlerts($user);

        return $this->render('JGAdminBundle:Account:alert/index.html.twig', array(
            'alerts' => $listAlerts
        ));
    }

    /**
     * Moderation choice alert.
     *
     * @Route("/moderate/{id}/valid", name="alert_valid")
     * @Method("GET")
     */
    public function validAction(Request $request, Alert $alert)
    {
        $response = $this->get('app.crud.update')->moderateAlert($alert, true);

        if ($response)
            $request->getSession()->getFlashBag()->add('success', 'Alerte validée avec succès !');
        else
            $request->getSession()->getFlashBag()->add('error', 'Erreur lors de la validation de l\'alerte !');

        return $this->redirectToRoute('alert_index');
    }

    /**
     * Moderation choice alert.
     *
     * @Route("/moderate/{id}/invalid", name="alert_invalid")
     * @Method("GET")
     */
    public function invalidAction(Request $request, Alert $alert)
    {
        $response = $this->get('app.crud.update')->moderateAlert($alert, false);

        if ($response)
            $request->getSession()->getFlashBag()->add('success', 'Alerte invalidée avec succès !');
        else
            $request->getSession()->getFlashBag()->add('error', 'Erreur lors de l\'invalidation de l\'alerte !');

        return $this->redirectToRoute('alert_index');
    }

    /**
     * Moderation choice alert.
     *
     * @Route("/delete/{id}/", name="alert_delete")
     * @Method("GET")
     */
    public function deleteAction(Request $request, Alert $alert)
    {
        $response = $this->get('app.crud.delete')->deleteEntity($alert);

        if ($response)
            $request->getSession()->getFlashBag()->add('success', 'Alerte supprimée avec succès !');
        else
            $request->getSession()->getFlashBag()->add('error', 'Erreur lors de la suppression de l\'alerte !');

        return $this->redirectToRoute('alert_index');
    }
}
