<?php

namespace JG\AdminBundle\Controller\Admin;

use JG\UserBundle\Entity\User;
use JG\UserBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * User controller.
 *
 * @Route("user")
 */
class UserController extends Controller
{
    /**
     * @Route("/list", name="user_index")
     */
    public function listUsersAction()
    {
        $users = $this->getDoctrine()->getRepository(User::class)->findAllUsers();

        $administrators = $this->getDoctrine()->getRepository(User::class)->findAllAdmin();

        $deleteForms = array();

        foreach ($users as $user) {
            $deleteForms[$user->getId()] = $this->createDeleteForm($user)->createView();
        }

        return $this->render('JGAdminBundle:Admin:user/index.html.twig',array(
            'users' => $users,
            'administrators' => $administrators,
            'deleteForms' => $deleteForms
        ));
    }

    /**
     * Export users
     *
     * @Route("/export/users", name="user_export_users")
     * @Method("GET")
     */
    public function exportUsersAction()
    {
        $headers = array('id','username','username_canonical','email','email_canonical','firstname','lastname','roles','enabled','created_at');

        $exportWS = $this->get('app.export');

        return $exportWS->export(new User(), 'exportUsers', null, $headers, 'export-users-'.date('YmdHis') );
    }

    /**
     * Export administrators
     *
     * @Route("/export/admins", name="user_export_admins")
     * @Method("GET")
     */
    public function exportAdministratorsWSAction()
    {
        $headers = array('id','username','username_canonical','email','email_canonical','firstname','lastname','roles','enabled','created_at');

        $exportWS = $this->get('app.export');

        return $exportWS->export(new User(), 'exportAdmins', null, $headers, 'export-administrators-'.date('YmdHis') );
    }

    /**
     * @Route("/new", name="user_new")
     */
    public function newAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $response = $this->get('app.crud.create')->createEntity($user);

            if ($response)
                $request->getSession()->getFlashBag()->add('success', 'Membre ajouté avec succès !');
            else
                $request->getSession()->getFlashBag()->add('success', 'Erreur lors de la création du membre !');

            return $this->redirectToRoute('user_index');
        }

        return $this->render('JGAdminBundle:Admin:user/new.html.twig',array(
            'user' => $user,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing user entity.
     *
     * @Route("/{id}/edit", name="user_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, User $user)
    {
        $deleteForm = $this->createDeleteForm($user);
        $editForm = $this->createForm(UserType::class, $user);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $request->getSession()->getFlashBag()->add('success', 'Membre modifié avec succès !');
            return $this->redirectToRoute('user_index');
        }

        return $this->render('JGAdminBundle:Admin:user/edit.html.twig', array(
            'user' => $user,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a user entity.
     *
     * @Route("/{id}/delete", name="user_delete")
     */
    public function deleteAction(Request $request, User $user)
    {
        $form = $this->createDeleteForm($user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $response = $this->get('app.crud.delete')->deleteEntity($user);

            if ($response)
                $request->getSession()->getFlashBag()->add('success', 'Membre supprimé avec succès !');
            else
                $request->getSession()->getFlashBag()->add('error', 'Erreur lors de la suppression du membre !');

            return $this->redirectToRoute('user_index');
        }

        return $this->render('JGAdminBundle:Admin:user/delete.html.twig', array(
            'user' => $user,
            'delete_form'  => $form->createView(),
        ));
    }

    /**
     * Creates a form to delete a user entity.
     *
     * @param User $user The user entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(User $user)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('user_delete', array('id' => $user->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

}
