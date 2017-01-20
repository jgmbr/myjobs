<?php

namespace JG\AdminBundle\Controller\Admin;

use JG\CoreBundle\Entity\State;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * State controller.
 *
 * @Route("state")
 */
class StateController extends Controller
{
    /**
     * Lists all state entities.
     *
     * @Route("/", name="state_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $states = $em->getRepository('JGCoreBundle:State')->findAll();

        return $this->render('JGAdminBundle:Admin:state/index.html.twig', array(
            'states' => $states,
        ));
    }

    /**
     * Creates a new state entity.
     *
     * @Route("/new", name="state_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $state = new State();
        $form = $this->createForm('JG\CoreBundle\Form\StateType', $state);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($state);
            $em->flush($state);
            $request->getSession()->getFlashBag()->add('success', 'Etat ajouté avec succès !');
            return $this->redirectToRoute('state_show', array('id' => $state->getId()));
        }

        return $this->render('JGAdminBundle:Admin:state/new.html.twig', array(
            'state' => $state,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a state entity.
     *
     * @Route("/{id}", name="state_show")
     * @Method("GET")
     */
    public function showAction(State $state)
    {
        $deleteForm = $this->createDeleteForm($state);

        return $this->render('JGAdminBundle:Admin:state/show.html.twig', array(
            'state' => $state,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing state entity.
     *
     * @Route("/{id}/edit", name="state_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, State $state)
    {
        $deleteForm = $this->createDeleteForm($state);
        $editForm = $this->createForm('JG\CoreBundle\Form\StateType', $state);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $request->getSession()->getFlashBag()->add('success', 'Etat modifié avec succès !');
            return $this->redirectToRoute('state_edit', array('id' => $state->getId()));
        }

        return $this->render('JGAdminBundle:Admin:state/edit.html.twig', array(
            'state' => $state,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a state entity.
     *
     * @Route("/{id}/delete", name="state_delete")
     */
    public function deleteAction(Request $request, State $state)
    {
        $form = $this->createDeleteForm($state);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($state);
            $em->flush($state);
            $request->getSession()->getFlashBag()->add('success', 'Etat supprimé avec succès !');
            return $this->redirectToRoute('state_index');
        }

        return $this->render('JGAdminBundle:Admin:state/delete.html.twig', array(
            'state' => $state,
            'delete_form'  => $form->createView(),
        ));
    }

    /**
     * Creates a form to delete a state entity.
     *
     * @param State $state The state entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(State $state)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('state_delete', array('id' => $state->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
