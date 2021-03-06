<?php

namespace JG\AdminBundle\Controller\Account;

use JG\CoreBundle\Entity\Company;
use JG\CoreBundle\Form\CompanyType;
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
     * @Route("/", name="company_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $companies = $em->getRepository(Company::class)->findMyCompanies($this->getUser());

        $deleteForms = array();

        foreach ($companies as $company) {
            $deleteForms[$company->getId()] = $this->createDeleteForm($company)->createView();
        }

        return $this->render('JGAdminBundle:Account:company/index.html.twig', array(
            'companies' => $companies,
            'deleteForms' => $deleteForms
        ));
    }

    /**
     * Export companies user
     *
     * @Route("/export/companies", name="company_export")
     * @Method("GET")
     */
    public function exportCompaniesAction()
    {
        $user = $this->getUser();

        $headers = array('id','name','address1','address2','postcode','city','country','email','phone','website','contact','created_at');

        $exportWS = $this->get('app.export');

        return $exportWS->export(new Company(), 'exportMyCompanies', null, $headers, 'export-companies-'.date('YmdHis'), $user);
    }

    /**
     * Creates a new company entity.
     *
     * @Route("/new", name="company_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $company = new Company();
        $form = $this->createForm(CompanyType::class, $company);
        $form->handleRequest($request);

        $user = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {

            $response = $this->get('app.crud.create')->createCompany($company, $user);

            if ($response) {
                $request->getSession()->getFlashBag()->add('success', 'Entreprise ajoutée avec succès !');
                return $this->redirectToRoute('company_show', array('id' => $company->getId()));
            } else {
                $request->getSession()->getFlashBag()->add('error', 'Erreur lors de l\'ajout de l\'entreprise !');
                return $this->redirectToRoute('company_new');
            }

        }

        return $this->render('JGAdminBundle:Account:company/new.html.twig', array(
            'company' => $company,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a company entity.
     *
     * @Route("/{id}", name="company_show")
     * @Method("GET")
     */
    public function showAction(Company $company)
    {
        // Check security author object

        $this->denyAccessUnlessGranted('show', $company);

        $deleteForm = $this->createDeleteForm($company);

        return $this->render('JGAdminBundle:Account:company/show.html.twig', array(
            'company' => $company,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing company entity.
     *
     * @Route("/{id}/edit", name="company_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Company $company)
    {
        // Check security author object

        $this->denyAccessUnlessGranted('edit', $company);

        $deleteForm = $this->createDeleteForm($company);
        $editForm = $this->createForm(CompanyType::class, $company);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $request->getSession()->getFlashBag()->add('success', 'Entreprise modifiée avec succès !');
            return $this->redirectToRoute('company_show', array('id' => $company->getId()));
        }

        return $this->render('JGAdminBundle:Account:company/edit.html.twig', array(
            'company' => $company,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a company entity.
     *
     * @Route("/{id}/delete", name="company_delete")
     */
    public function deleteAction(Request $request, Company $company)
    {
        // Check security author object

        $this->denyAccessUnlessGranted('delete', $company);

        $form = $this->createDeleteForm($company);
        $form->handleRequest($request);

        $user = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {

            $response = $this->get('app.crud.delete')->deleteCompany($company, $user);

            if ($response)
                $request->getSession()->getFlashBag()->add('success', 'Entreprise supprimée avec succès !');
            else
                $request->getSession()->getFlashBag()->add('error', 'Erreur lors de la suppression de l\'entreprise');

            return $this->redirectToRoute('company_index');

        }

        return $this->render('JGAdminBundle:Account:company/delete.html.twig', array(
            'company' => $company,
            'delete_form'  => $form->createView(),
        ));
    }

    /**
     * Creates a form to delete a company entity.
     *
     * @param Company $company The company entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Company $company)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('company_delete', array('id' => $company->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
