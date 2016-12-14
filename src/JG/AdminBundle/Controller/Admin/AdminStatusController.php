<?php

namespace JG\AdminBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminStatusController extends Controller
{
    /**
     * @Route("/admin/status/list", name="admin_status_list_page")
     */
    public function listStatusAction()
    {
        return $this->render('JGAdminBundle:Admin:Status/list.html.twig');
    }

}
