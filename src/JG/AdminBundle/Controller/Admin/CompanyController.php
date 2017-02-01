<?php

namespace JG\AdminBundle\Controller\Admin;

use JG\CoreBundle\Entity\Company;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Company controller.
 *
 * @Route("company")
 */
class CompanyController extends Controller
{
    /**
     * Lists all company entities.
     *
     * @Route("/", name="company_list")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $companies = $em->getRepository('JGCoreBundle:Company')->findAll();

        return $this->render('JGAdminBundle:Admin:company/index.html.twig', array(
            'companies' => $companies,
        ));
    }

    /**
     * Export companies
     *
     * @Route("/export/companies/all", name="company_export_all")
     * @Method("GET")
     */
    public function exportAllCompaniesAction()
    {
        $user = $this->getUser();

        $headers = array('id','name','address1','address2','postcode','city','country','email','phone','website','contact','created_at');

        $exportWS = $this->get('app.export');

        return $exportWS->export('JGCoreBundle:Company', 'exportAllCompanies', null, $headers, 'export-all-companies-'.date('YmdHis'), $user);
    }

    /**
     * Finds and displays a company entity.
     *
     * @Route("/{id}", name="company_list_show")
     * @Method("GET")
     */
    public function showAction(Company $company)
    {
        return $this->render('JGAdminBundle:Admin:company/show.html.twig', array(
            'company' => $company
        ));
    }

}
