<?php

namespace JG\AdminBundle\Controller\Account;

use JG\CoreBundle\Entity\Appointment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Appointment controller.
 *
 * @Route("appointment")
 */
class AccountAppointmentController extends Controller
{
    /**
     * Lists all appointment entities.
     *
     * @Route("/", name="appointment_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $appointments = $em->getRepository('JGCoreBundle:Appointment')->findMyAppointments($this->getUser());

        $states = $em->getRepository('JGCoreBundle:State')->findAll();

        return $this->render('JGAdminBundle:Account:appointment/index.html.twig', array(
            'appointments'  => $appointments,
            'states'        => $states
        ));
    }

    /**
     * Creates a new appointment entity.
     *
     * @Route("/new", name="appointment_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $appointment = new Appointment();
        $form = $this->createForm('JG\CoreBundle\Form\AppointmentType', $appointment, array('current_user' => $this->getUser()));
        $form->handleRequest($request);

        $user = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $appointment->setUser($user);
            $user->addAppointment($appointment);

            $em->persist($appointment);
            $em->flush($appointment);

            $request->getSession()->getFlashBag()->add('success', 'Entretien ajoutée avec succès !');
            return $this->redirectToRoute('appointment_show', array('id' => $appointment->getId()));
        }

        return $this->render('JGAdminBundle:Account:appointment/new.html.twig', array(
            'appointment' => $appointment,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a appointment entity.
     *
     * @Route("/{id}", name="appointment_show")
     * @Method("GET")
     */
    public function showAction(Appointment $appointment)
    {
        $deleteForm = $this->createDeleteForm($appointment);

        return $this->render('JGAdminBundle:Account:appointment/show.html.twig', array(
            'appointment' => $appointment,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing appointment entity.
     *
     * @Route("/{id}/edit", name="appointment_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Appointment $appointment)
    {
        $deleteForm = $this->createDeleteForm($appointment);
        $editForm = $this->createForm('JG\CoreBundle\Form\AppointmentType', $appointment, array('current_user' => $this->getUser()));
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $request->getSession()->getFlashBag()->add('success', 'Entretien modifié avec succès !');
            return $this->redirectToRoute('appointment_show', array('id' => $appointment->getId()));
        }

        return $this->render('JGAdminBundle:Account:appointment/edit.html.twig', array(
            'appointment' => $appointment,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a appointment entity.
     *
     * @Route("/{id}/delete", name="appointment_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Appointment $appointment)
    {
        $form = $this->createDeleteForm($appointment);
        $form->handleRequest($request);

        $user = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $user->removeAppointment($appointment);
            $em->remove($appointment);
            $em->flush($appointment);
            $request->getSession()->getFlashBag()->add('success', 'Entretien supprimé avec succès !');
            return $this->redirectToRoute('appointment_index');
        }

        return $this->render('JGAdminBundle:Account:appointment/delete.html.twig', array(
            'appointment'   => $appointment,
            'delete_form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to delete a appointment entity.
     *
     * @param Appointment $appointment The appointment entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Appointment $appointment)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('appointment_delete', array('id' => $appointment->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
