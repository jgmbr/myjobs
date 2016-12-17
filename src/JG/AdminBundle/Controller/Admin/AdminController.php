<?php

namespace JG\AdminBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    /**
     * @Route("/admin/index", name="admin_home_page")
     */
    public function indexAction()
    {
        $user               = $this->getUser();
        $nbUsers            = $this->getDoctrine()->getRepository('JGUserBundle:User')->findCountUsers();
        $nbAdministrators   = $this->getDoctrine()->getRepository('JGUserBundle:User')->findCountAdmin();
        $nbContrats         = $this->getDoctrine()->getRepository('JGCoreBundle:Contract')->findCount();
        $nbStatus           = $this->getDoctrine()->getRepository('JGCoreBundle:Status')->findCount();

        return $this->render('JGAdminBundle:Admin:index.html.twig',array(
            'user'              => $user,
            'nbUsers'           => $nbUsers,
            'nbAdministrators'  => $nbAdministrators,
            'nbContracts'       => $nbContrats,
            'nbStatus'          => $nbStatus
        ));
    }
}