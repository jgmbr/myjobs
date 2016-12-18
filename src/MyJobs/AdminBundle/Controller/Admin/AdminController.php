<?php

namespace MyJobs\AdminBundle\Controller\Admin;

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
        $nbUsers            = $this->getDoctrine()->getRepository('MyJobsUserBundle:User')->findCountUsers();
        $nbAdministrators   = $this->getDoctrine()->getRepository('MyJobsUserBundle:User')->findCountAdmin();
        $nbContrats         = $this->getDoctrine()->getRepository('MyJobsCoreBundle:Contract')->findCount();
        $nbStatus           = $this->getDoctrine()->getRepository('MyJobsCoreBundle:Status')->findCount();

        return $this->render('MyJobsAdminBundle:Admin:index.html.twig',array(
            'user'              => $user,
            'nbUsers'           => $nbUsers,
            'nbAdministrators'  => $nbAdministrators,
            'nbContracts'       => $nbContrats,
            'nbStatus'          => $nbStatus
        ));
    }
}