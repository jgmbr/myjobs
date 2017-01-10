<?php

namespace JG\AdminBundle\Controller\Account;

use JG\CoreBundle\Entity\Application;
use JG\CoreBundle\Entity\Relaunch;
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
class AccountApplicationController extends Controller
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

        $applications = $em->getRepository('JGCoreBundle:Application')->findMyApplications($this->getUser());

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
     * Creates a new application entity.
     *
     * @Route("/new", name="application_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $application = new Application();
        $form = $this->createForm('JG\CoreBundle\Form\ApplicationType', $application, array('current_user' => $this->getUser()));
        $form->handleRequest($request);

        $user = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $application->setUser($user);
            $user->addApplication($application);

            $em->persist($application);
            $em->flush($application);

            $request->getSession()->getFlashBag()->add('success', 'Candidature ajoutée avec succès !');
            return $this->redirectToRoute('application_show', array('id' => $application->getId()));
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
        $deleteForm = $this->createDeleteForm($application);

        $relaunch = new Relaunch();
        $form = $this->createForm('JG\CoreBundle\Form\RelaunchType', $relaunch, array(
            'current_user'  => $this->getUser()
        ));

        return $this->render('JGAdminBundle:Account:application/show.html.twig', array(
            'application' => $application,
            'delete_form' => $deleteForm->createView(),
            'formRelaunch' => $form->createView()
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
        $form = $this->createForm('JG\CoreBundle\Form\RelaunchType', $relaunch, array('current_user' => $this->getUser()));
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $relaunch->setApplication($application);
            $application->addRelaunch($relaunch);

            $em->persist($relaunch);
            $em->flush($relaunch);

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
        $deleteForm = $this->createDeleteForm($application);
        $editForm = $this->createForm('JG\CoreBundle\Form\ApplicationType', $application, array('current_user' => $this->getUser()));
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
        $form = $this->createDeleteForm($application);
        $form->handleRequest($request);

        $user = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $user->removeApplication($application);
            $em->remove($application);
            $em->flush($application);
            $request->getSession()->getFlashBag()->add('success', 'Candidature supprimée avec succès !');
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
