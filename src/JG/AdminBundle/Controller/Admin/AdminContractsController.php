<?php

namespace JG\AdminBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminContractsController extends Controller
{
    /**
     * @Route("/admin/contracts/list", name="admin_contracts_list_page")
     */
    public function listContractsAction()
    {
        return $this->render('JGAdminBundle:Admin:Contract/list.html.twig');
    }

}
