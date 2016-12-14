<?php

namespace JG\AdminBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminUsersController extends Controller
{
    /**
     * @Route("/admin/users/list", name="admin_users_list_page")
     */
    public function listUsersAction()
    {
        return $this->render('JGAdminBundle:Admin:User/list.html.twig');
    }

}
