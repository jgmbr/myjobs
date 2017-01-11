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
class AccountRelaunchController extends Controller
{
    /**
     * Lists all relaunch entities.
     *
     * @Route("/", name="relaunch_index")
     * @Method("GET")
     */
    /*public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $relaunches = $em->getRepository('JGCoreBundle:Relaunch')->findAll();

        return $this->render('relaunch/index.html.twig', array(
            'relaunches' => $relaunches,
        ));
    }*/

    /**
     * Creates a new relaunch entity.
     *
     * @Route("/new", name="relaunch_new")
     * @Method({"GET", "POST"})
     */
    /*public function newAction(Request $request)
    {
        $relaunch = new Relaunch();
        $form = $this->createForm('JG\CoreBundle\Form\RelaunchType', $relaunch);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($relaunch);
            $em->flush($relaunch);

            return $this->redirectToRoute('relaunch_show', array('id' => $relaunch->getId()));
        }

        return $this->render('relaunch/new.html.twig', array(
            'relaunch' => $relaunch,
            'form' => $form->createView(),
        ));
    }*/

    /**
     * Finds and displays a relaunch entity.
     *
     * @Route("/{id}", name="relaunch_show")
     * @Method("GET")
     */
    /*public function showAction(Relaunch $relaunch)
    {
        $deleteForm = $this->createDeleteForm($relaunch);

        return $this->render('relaunch/show.html.twig', array(
            'relaunch' => $relaunch,
            'delete_form' => $deleteForm->createView(),
        ));
    }*/

    /**
     * Displays a form to edit an existing relaunch entity.
     *
     * @Route("/{id}/edit", name="relaunch_edit")
     * @Method({"GET", "POST"})
     */
    /*public function editAction(Request $request, Relaunch $relaunch)
    {
        $deleteForm = $this->createDeleteForm($relaunch);
        $editForm = $this->createForm('JG\CoreBundle\Form\RelaunchType', $relaunch);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('relaunch_edit', array('id' => $relaunch->getId()));
        }

        return $this->render('relaunch/edit.html.twig', array(
            'relaunch' => $relaunch,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }*/

    /**
     * Deletes a relaunch entity.
     *
     * @Route("/{id}/delete", name="relaunch_delete_link")
     */
    public function deleteRelaunchAction(Request $request, Relaunch $relaunch)
    {
        $application = $relaunch->getApplication();

        $em = $this->getDoctrine()->getManager();
        $em->remove($relaunch);
        $em->flush($relaunch);

        $request->getSession()->getFlashBag()->add('success', 'Relance supprimée avec succès !');

        return $this->redirectToRoute('application_show', array('id' => $application->getId()));
    }

    /**
     * Creates a form to delete a relaunch entity.
     *
     * @param Relaunch $relaunch The relaunch entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    /*private function createDeleteForm(Relaunch $relaunch)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('relaunch_delete', array('id' => $relaunch->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }*/
}
