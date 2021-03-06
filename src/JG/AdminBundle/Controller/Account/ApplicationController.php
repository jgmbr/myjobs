<?php

namespace JG\AdminBundle\Controller\Account;

use JG\CoreBundle\Entity\Application;
use JG\CoreBundle\Entity\Appointment;
use JG\CoreBundle\Entity\EntityInterface\ExportInterface;
use JG\CoreBundle\Entity\Relaunch;
use JG\CoreBundle\Form\ApplicationType;
use JG\CoreBundle\Form\RelaunchType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Application controller.
 *
 * @Route("application")
 */
class ApplicationController extends Controller
{
    /**
     * Lists all application entities.
     *
     * @Route("/", name="application_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $applications = $em->getRepository(Application::class)->findMyApplications($this->getUser());

        $deleteForms = array();

        foreach ($applications as $application) {
            $deleteForms[$application->getId()] = $this->createDeleteForm($application)->createView();
        }

        return $this->render('JGAdminBundle:Account:application/index.html.twig', array(
            'applications' => $applications,
            'deleteForms' => $deleteForms
        ));
    }

    /**
     * Export applications user
     *
     * @Route("/export/applications", name="application_export")
     * @Method("GET")
     */
    public function exportApplicationsAction()
    {
        $user = $this->getUser();

        $headers = array('id','date_at','name','url','contract','state','company','comment','business_reason','people_reason','created_at');

        $exportWS = $this->get('app.export');

        return $exportWS->export(new Application(), 'exportMyApplications', null, $headers, 'export-applications-'.date('YmdHis'), $user);
    }

    /**
     * Creates a new application entity.
     *
     * @Route("/new", name="application_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $application = new Application();
        $form = $this->createForm(ApplicationType::class, $application, array('current_user' => $this->getUser()));
        $form->handleRequest($request);

        $user = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {

            $response = $this->get('app.crud.create')->createApplication($application, $user);

            if ($response) {
                $request->getSession()->getFlashBag()->add('success', 'Candidature ajoutée avec succès !');
                return $this->redirectToRoute('application_show', array('id' => $application->getId()));
            } else {
                $request->getSession()->getFlashBag()->add('error', 'Erreur lors de l\'ajout de la candidature');
                return $this->redirectToRoute('application_new');
            }

        }

        return $this->render('JGAdminBundle:Account:application/new.html.twig', array(
            'application' => $application,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a application entity.
     *
     * @Route("/{id}", name="application_show")
     * @Method("GET")
     */
    public function showAction(Request $request, Application $application)
    {
        // Check security author object

        $this->denyAccessUnlessGranted('show', $application);

        // Current application delete form

        $deleteForm = $this->createDeleteForm($application);

        $relaunch = new Relaunch();
        $form = $this->createForm(RelaunchType::class, $relaunch, array('current_user'  => $this->getUser()));

        // Appointments delete forms

        $em = $this->getDoctrine()->getManager();

        $appointments = $em->getRepository(Appointment::class)->findMyAppointments($this->getUser());

        $deleteAppointmentForms = array();

        foreach ($appointments as $appointment) {
            $deleteAppointmentForms[$appointment->getId()] =
                $this->createFormBuilder()
                    ->setAction($this->generateUrl('appointment_delete', array('id' => $appointment->getId())))
                    ->setMethod('DELETE')
                    ->getForm()
                    ->createView()
            ;
        }

        // Relaunches delete forms

        $relaunches = $application->getRelaunches();

        $deleteRelaunchForms = array();

        foreach ($relaunches as $relaunch) {
            $deleteRelaunchForms[$relaunch->getId()] =
                $this->createFormBuilder()
                    ->setAction($this->generateUrl('relaunch_delete', array('id' => $relaunch->getId())))
                    ->setMethod('DELETE')
                    ->getForm()
                    ->createView()
            ;
        }

        return $this->render('JGAdminBundle:Account:application/show.html.twig', array(
            'application' => $application,
            'delete_form' => $deleteForm->createView(),
            'formRelaunch' => $form->createView(),
            'deleteAppointmentForms' => $deleteAppointmentForms,
            'deleteRelaunchForms' => $deleteRelaunchForms
        ));
    }

    /**
     * @Route("/addRelaunch/{id}", name="add_relaunch")
     * @Method("POST")
     */
    public function addRelaunchAction(Request $request, Application $application)
    {
        if (!$request->isXmlHttpRequest()) {
            return new JsonResponse(array('message' => 'You can access this only using Ajax!'), 400);
        }

        $relaunch = new Relaunch();
        $form = $this->createForm(RelaunchType::class, $relaunch, array('current_user' => $this->getUser()));
        $form->handleRequest($request);

        if ($form->isValid()) {

            $this->get('app.crud.create')->createRelaunch($application, $relaunch);

            return new JsonResponse(array('message' => 'Success'), 200);
        }

        $response = new JsonResponse(
            array(
                'message'   => 'Error',
                'form'      => $form->createView()
            )
        , 400);

        return $response;
    }

    /**
     * Displays a form to edit an existing application entity.
     *
     * @Route("/{id}/edit", name="application_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Application $application)
    {
        // Check security author object

        $this->denyAccessUnlessGranted('edit', $application);

        $deleteForm = $this->createDeleteForm($application);
        $editForm = $this->createForm(ApplicationType::class, $application, array('current_user' => $this->getUser()));
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $request->getSession()->getFlashBag()->add('success', 'Candidature modifiée avec succès !');
            return $this->redirectToRoute('application_show', array('id' => $application->getId()));
        }

        return $this->render('JGAdminBundle:Account:application/edit.html.twig', array(
            'application' => $application,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a application entity.
     *
     * @Route("/{id}/delete", name="application_delete")
     */
    public function deleteAction(Request $request, Application $application)
    {
        // Check security author object

        $this->denyAccessUnlessGranted('delete', $application);

        $form = $this->createDeleteForm($application);
        $form->handleRequest($request);

        $user = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {

            $response = $this->get('app.crud.delete')->deleteApplication($application, $user);

            if ($response)
                $request->getSession()->getFlashBag()->add('success', 'Candidature supprimée avec succès !');
            else
                $request->getSession()->getFlashBag()->add('error', 'Erreur lors de la suppression de la candidature!');

            return $this->redirectToRoute('application_index');
        }

        return $this->render('JGAdminBundle:Account:application/delete.html.twig', array(
            'application' => $application,
            'delete_form'  => $form->createView(),
        ));
    }

    /**
     * Creates a form to delete a application entity.
     *
     * @param Application $application The application entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Application $application)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('application_delete', array('id' => $application->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
