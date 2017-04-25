<?php

namespace JG\AdminBundle\Controller\Account;

use JG\CoreBundle\Entity\Relaunch;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Relaunch controller.
 *
 * @Route("relaunch")
 */
class RelaunchController extends Controller
{
    /**
     * Deletes a relaunch entity.
     *
     * @Route("/{id}/delete", name="relaunch_delete")
     */
    public function deleteAction(Request $request, Relaunch $relaunch)
    {
        // Check security author object

        $this->denyAccessUnlessGranted('delete', $relaunch);

        $form = $this->createDeleteForm($relaunch);
        $form->handleRequest($request);

        $user = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {

            $response = $this->get('app.crud.delete')->deleteRelaunch($relaunch, $user);

            if ($response)
                $request->getSession()->getFlashBag()->add('success', 'Relance supprimée avec succès !');
            else
                $request->getSession()->getFlashBag()->add('error', 'Erreur lors de la suppression de la relance !');

            return $this->redirectToRoute('application_show', array('id' => $relaunch->getApplication()->getId()));
        }

        return $this->render('JGAdminBundle:Account:appointment/delete.html.twig', array(
            'relaunch'   => $relaunch,
            'delete_form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to delete a relaunch entity.
     *
     * @param Relaunch $relaunch The relaunch entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Relaunch $relaunch)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('relaunch_delete', array('id' => $relaunch->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
