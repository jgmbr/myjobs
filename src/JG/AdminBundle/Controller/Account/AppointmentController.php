<?php

namespace JG\AdminBundle\Controller\Account;

use JG\CoreBundle\Entity\Appointment;
use JG\CoreBundle\Entity\State;
use JG\CoreBundle\Form\AppointmentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Appointment controller.
 *
 * @Route("appointment")
 */
class AppointmentController extends Controller
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

        $appointments = $em->getRepository(Appointment::class)->findMyAppointments($this->getUser());

        $states = $em->getRepository(State::class)->findAll();

        return $this->render('JGAdminBundle:Account:appointment/index.html.twig', array(
            'appointments'  => $appointments,
            'states'        => $states
        ));
    }

    /**
     * Export appointments user
     *
     * @Route("/export/appointments", name="appointment_export")
     * @Method("GET")
     */
    public function exportAppointmentsAction()
    {
        $user = $this->getUser();

        $headers = array('id','name','state','company','date_at','hour_at','comment','created_at');

        $exportWS = $this->get('app.export');

        return $exportWS->export(new Appointment(), 'exportMyAppointments', null, $headers, 'export-appointments-'.date('YmdHis'), $user);
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
        $form = $this->createForm(AppointmentType::class, $appointment, array('current_user' => $this->getUser()));
        $form->handleRequest($request);

        $user = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {

            $response = $this->get('app.crud.create')->createAppointment($appointment, $user);

            if ($response) {
                $request->getSession()->getFlashBag()->add('success', 'Entretien ajouté avec succès !');
                return $this->redirectToRoute('appointment_show', array('id' => $appointment->getId()));
            } else {
                $request->getSession()->getFlashBag()->add('error', 'Erreur lors de l\'ajout de l\'entretien');
                return $this->redirectToRoute('appointment_new');
            }

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
        // Check security author object

        $this->denyAccessUnlessGranted('show', $appointment);

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
        // Check security author object

        $this->denyAccessUnlessGranted('edit', $appointment);

        $deleteForm = $this->createDeleteForm($appointment);
        $editForm = $this->createForm(AppointmentType::class, $appointment, array('current_user' => $this->getUser()));
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
     */
    public function deleteAction(Request $request, Appointment $appointment)
    {
        // Check security author object

        $this->denyAccessUnlessGranted('delete', $appointment);

        $form = $this->createDeleteForm($appointment);
        $form->handleRequest($request);

        $user = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {

            $response = $this->get('app.crud.delete')->deleteAppointment($appointment, $user);

            if ($response)
                $request->getSession()->getFlashBag()->add('success', 'Entretien supprimé avec succès !');
            else
                $request->getSession()->getFlashBag()->add('error', 'Erreur lors de la suppression de l\'entretien');

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
