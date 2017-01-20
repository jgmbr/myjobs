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
