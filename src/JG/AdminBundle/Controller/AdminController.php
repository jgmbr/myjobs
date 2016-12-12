<?php

namespace JG\AdminBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    /**
     * @Route("/admin/index", name="admin_home_page")
     */
    public function indexAction()
    {
        $user = $this->getUser();

        var_dump($user);

        return $this->render('JGAdminBundle:Admin:index.html.twig');
    }
}
