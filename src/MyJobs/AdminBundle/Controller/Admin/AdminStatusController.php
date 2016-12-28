<?php

namespace MyJobs\AdminBundle\Controller\Admin;

use MyJobs\CoreBundle\Entity\Status;
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
     * @Route("/", name="status_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $statuses = $em->getRepository('MyJobsCoreBundle:Status')->findAll();

        $deleteForms = array();

        foreach ($statuses as $status) {
            $deleteForms[$status->getId()] = $this->createDeleteForm($status)->createView();
        }

        return $this->render('MyJobsAdminBundle:Admin:status/index.html.twig', array(
            'statuses' => $statuses,
            'deleteForms' => $deleteForms
        ));
    }

    /**
     * Creates a new status entity.
     *
     * @Route("/new", name="status_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $status = new Status();
        $form = $this->createForm('MyJobs\CoreBundle\Form\StatusType', $status);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($status);
            $em->flush($status);

            return $this->redirectToRoute('status_show', array('id' => $status->getId()));
        }

        return $this->render('MyJobsAdminBundle:Admin:status/new.html.twig', array(
            'status' => $status,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a status entity.
     *
     * @Route("/{id}", name="status_show")
     * @Method("GET")
     */
    public function showAction(Status $status)
    {
        $deleteForm = $this->createDeleteForm($status);

        return $this->render('MyJobsAdminBundle:Admin:status/show.html.twig', array(
            'status' => $status,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing status entity.
     *
     * @Route("/{id}/edit", name="status_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Status $status)
    {
        $deleteForm = $this->createDeleteForm($status);
        $editForm = $this->createForm('MyJobs\CoreBundle\Form\StatusType', $status);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('status_show', array('id' => $status->getId()));
        }

        return $this->render('MyJobsAdminBundle:Admin:status/edit.html.twig', array(
            'status' => $status,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a status entity.
     *
     * @Route("/{id}/delete", name="status_delete")
     */
    public function deleteAction(Request $request, Status $status)
    {
        $form = $this->createDeleteForm($status);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($status);
            $em->flush($status);

            return $this->redirectToRoute('status_index');
        }

        return $this->render('MyJobsAdminBundle:Admin:status/delete.html.twig', array(
            'status' => $status,
            'delete_form'  => $form->createView(),
        ));
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
