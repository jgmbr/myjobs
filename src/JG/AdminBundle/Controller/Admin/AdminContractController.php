<?php

namespace JG\AdminBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminContractController extends Controller
{
    /**
     * @Route("/admin/contract/list", name="admin_contract_list_page")
     */
    public function listContractsAction()
    {
        return $this->render('JGAdminBundle:Admin:Contract/list.html.twig');
    }

}
