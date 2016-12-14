<?php

namespace JG\AdminBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminUserController extends Controller
{
    /**
     * @Route("/admin/user/list", name="admin_user_list_page")
     */
    public function listUsersAction()
    {
        return $this->render('JGAdminBundle:Admin:User/list.html.twig');
    }

}
