<?php

namespace MyJobs\AdminBundle\Controller\Admin;

use MyJobs\UserBundle\Entity\User;
use MyJobs\UserBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * User controller.
 *
 * @Route("user")
 */
class AdminUserController extends Controller
{
    /**
     * @Route("/list", name="user_index")
     */
    public function listUsersAction()
    {
        $users = $this->getDoctrine()->getRepository('MyJobsUserBundle:User')->findAllUsers();

        $administrators = $this->getDoctrine()->getRepository('MyJobsUserBundle:User')->findAllAdmin();

        return $this->render('MyJobsAdminBundle:Admin:user/index.html.twig',array(
            'users' => $users,
            'administrators' => $administrators
        ));
    }

    /**
     * @Route("/new", name="user_new")
     */
    public function newAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm('MyJobs\UserBundle\Form\UserType', $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            //$user->setEnabled(true);
            $em->persist($user);
            $em->flush($user);

            /*$newUser = $userManager->createUser();
            $newUser->setUsername($form->get('username')->getData());
            $newUser->setEmail($form->get('email')->getData());
            $newUser->setPlainPassword($form->get('plainPassword')->getData());
            $newUser->setEnabled(true);
            $newUser->setRole($form->get('role')->getData());
            $userManager->updateUser($newUser);*/

            return $this->redirectToRoute('user_index');
        }

        return $this->render('MyJobsAdminBundle:Admin:user/new.html.twig',array(
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
        $editForm = $this->createForm('MyJobs\UserBundle\Form\UserType', $user);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_index', array('id' => $user->getId()));
        }

        return $this->render('MyJobsAdminBundle:Admin:user/edit.html.twig', array(
            'user' => $user,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a user entity.
     *
     * @Route("/{id}", name="user_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, User $user)
    {
        $form = $this->createDeleteForm($user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush($user);
        }

        return $this->redirectToRoute('user_index');
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
