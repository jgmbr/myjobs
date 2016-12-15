<?php

namespace JG\AdminBundle\Controller\Admin;

use JG\UserBundle\Entity\User;
use JG\UserBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AdminUserController extends Controller
{
    /**
     * @Route("/admin/user/list", name="admin_user_list_page")
     */
    public function listUsersAction()
    {
        $users = $this->getDoctrine()->getRepository('JGUserBundle:User')->findAllUsers();

        $administrators = $this->getDoctrine()->getRepository('JGUserBundle:User')->findAllAdmin();

        return $this->render('JGAdminBundle:Admin:User/list.html.twig',array(
            'users' => $users,
            'administrators' => $administrators
        ));
    }

    /**
     * @Route("/admin/user/add/", name="admin_user_add")
     */
    public function addUserAction(Request $request)
    {
        $userManager = $this->get('fos_user.user_manager');

        $user = new User();

        $form = $this->get('form.factory')->create(UserType::class, $user);

//        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
//
//            $newUser = $userManager->createUser();
//            $newUser->setUsername($request->request->get('username'));
//            $newUser->setEmail($request->request->get('email'));
//            $newUser->setUsername($request->request->get('username'));
//            $newUser->setEmail($request->request->get('email'));
//            $newUser->setPlainPassword($request->request->get('password'));
//            $newUser->setEnabled((bool) $request->request->get('active'));
//            $newUser->addRole($request->request->get('role'));
//            $userManager->updateUser($newUser);
//
//            $request->getSession()->getFlashBag()->add('success', 'Message envoyé avec succès !');
//            return $this->redirectToRoute('admin_user_list_page');
//        }

        return $this->render('JGAdminBundle:Admin:User/add.html.twig',array(
            'form' => $form->createView(),
        ));
    }

}
