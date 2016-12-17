<?php

namespace JG\AdminBundle\Controller\Admin;

use JG\CoreBundle\Entity\Status;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Status controller.
 *
 * @Route("status")
 */
class AdminStatusController extends Controller
{
    /**
     * Lists all status entities.
     *
     * @Route("/admin/status", name="status_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $statuses = $em->getRepository('JGCoreBundle:Status')->findAll();

        return $this->render('JGAdminBundle:Admin:status/index.html.twig', array(
            'statuses' => $statuses,
        ));
    }

    /**
     * Creates a new status entity.
     *
     * @Route("/admin/status/new", name="status_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $status = new Status();
        $form = $this->createForm('JG\CoreBundle\Form\StatusType', $status);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($status);
            $em->flush($status);

            return $this->redirectToRoute('status_show', array('id' => $status->getId()));
        }

        return $this->render('JGAdminBundle:Admin:status/new.html.twig', array(
            'status' => $status,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a status entity.
     *
     * @Route("/admin/status/{id}", name="status_show")
     * @Method("GET")
     */
    public function showAction(Status $status)
    {
        $deleteForm = $this->createDeleteForm($status);

        return $this->render('JGAdminBundle:Admin:status/show.html.twig', array(
            'status' => $status,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing status entity.
     *
     * @Route("/admin/status/{id}/edit", name="status_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Status $status)
    {
        $deleteForm = $this->createDeleteForm($status);
        $editForm = $this->createForm('JG\CoreBundle\Form\StatusType', $status);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('status_index', array('id' => $status->getId()));
        }

        return $this->render('JGAdminBundle:Admin:status/edit.html.twig', array(
            'status' => $status,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a status entity.
     *
     * @Route("/admin/status/{id}", name="status_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Status $status)
    {
        $form = $this->createDeleteForm($status);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($status);
            $em->flush($status);
        }

        return $this->redirectToRoute('status_index');
    }

    /**
     * Creates a form to delete a status entity.
     *
     * @param Status $status The status entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Status $status)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('status_delete', array('id' => $status->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
