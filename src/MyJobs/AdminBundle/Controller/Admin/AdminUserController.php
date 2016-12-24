<?php

namespace MyJobs\AdminBundle\Controller\Admin;

use MyJobs\UserBundle\Entity\User;
use MyJobs\UserBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AdminUserController extends Controller
{
    /**
     * @Route("/user/list", name="admin_user_list_page")
     */
    public function listUsersAction()
    {
        $users = $this->getDoctrine()->getRepository('MyJobsUserBundle:User')->findAllUsers();

        $administrators = $this->getDoctrine()->getRepository('MyJobsUserBundle:User')->findAllAdmin();

        return $this->render('MyJobsAdminBundle:Admin:user/list.html.twig',array(
            'users' => $users,
            'administrators' => $administrators
        ));
    }

    /**
     * @Route("/user/add/", name="admin_user_add")
     */
    public function addUserAction(Request $request)
    {
        $userManager = $this->get('fos_user.user_manager');

        $user = new User();

        $form = $this->get('form.factory')->create(UserType::class, $user);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $user->setEnabled(true);
            if ($form->get('role')->getData() == 'ROLE_ADMIN') {
                $user->setSuperAdmin(true);
            }
            $em->persist($user);
            $em->flush($user);

            /*$newUser = $userManager->createUser();
            $newUser->setUsername($form->get('username')->getData());
            $newUser->setEmail($form->get('email')->getData());
            $newUser->setPlainPassword($form->get('plainPassword')->getData());
            $newUser->setEnabled(true);
            $newUser->setRole($form->get('role')->getData());
            $userManager->updateUser($newUser);*/

            $request->getSession()->getFlashBag()->add('success', 'Message envoyé avec succès !');
            return $this->redirectToRoute('admin_user_list_page');
        }

        return $this->render('MyJobsAdminBundle:Admin:user/add.html.twig',array(
            'form' => $form->createView(),
        ));
    }

}
