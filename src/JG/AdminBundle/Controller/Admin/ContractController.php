<?php

namespace JG\AdminBundle\Controller\Admin;

use JG\CoreBundle\Entity\Contract;
use JG\CoreBundle\Form\ContractType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Contract controller.
 *
 * @Route("contract")
 */
class ContractController extends Controller
{
    /**
     * Lists all contract entities.
     *
     * @Route("/", name="contract_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $contracts = $em->getRepository(Contract::class)->findAll();

        $deleteForms = array();

        foreach ($contracts as $contract) {
            $deleteForms[$contract->getId()] = $this->createDeleteForm($contract)->createView();
        }

        return $this->render('JGAdminBundle:Admin:contract/index.html.twig', array(
            'contracts' => $contracts,
            'deleteForms' => $deleteForms
        ));
    }

    /**
     * Creates a new contract entity.
     *
     * @Route("/new", name="contract_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $contract = new Contract();
        $form = $this->createForm(ContractType::class, $contract);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $response = $this->get('app.crud.create')->createEntity($contract);

            if ($response) {
                $request->getSession()->getFlashBag()->add('success', 'Contrat ajouté avec succès !');
                return $this->redirectToRoute('contract_show', array('id' => $contract->getId()));
            } else {
                $request->getSession()->getFlashBag()->add('error', 'Erreurs de la création du contrat !');
                return $this->redirectToRoute('contract_new');
            }
        }

        return $this->render('JGAdminBundle:Admin:contract/new.html.twig', array(
            'contract' => $contract,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a contract entity.
     *
     * @Route("/{id}", name="contract_show")
     * @Method("GET")
     */
    public function showAction(Contract $contract)
    {
        $deleteForm = $this->createDeleteForm($contract);

        return $this->render('JGAdminBundle:Admin:contract/show.html.twig', array(
            'contract' => $contract,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing contract entity.
     *
     * @Route("/{id}/edit", name="contract_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Contract $contract)
    {
        $deleteForm = $this->createDeleteForm($contract);
        $editForm = $this->createForm(ContractType::class, $contract);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $request->getSession()->getFlashBag()->add('success', 'Contrat modifié avec succès !');
            return $this->redirectToRoute('contract_show', array('id' => $contract->getId()));
        }

        return $this->render('JGAdminBundle:Admin:contract/edit.html.twig', array(
            'contract' => $contract,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a contract entity.
     *
     * @Route("/{id}/delete", name="contract_delete")
     */
    public function deleteAction(Request $request, Contract $contract)
    {
        $form = $this->createDeleteForm($contract);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $response = $this->get('app.crud.delete')->deleteEntity($contract);

            if ($response)
                $request->getSession()->getFlashBag()->add('success', 'Contrat supprimé avec succès !');
            else
                $request->getSession()->getFlashBag()->add('error', 'Erreur lors de la suppression du contrat !');

            return $this->redirectToRoute('contract_index');
        }

        return $this->render('JGAdminBundle:Admin:contract/delete.html.twig', array(
            'contract' => $contract,
            'delete_form'  => $form->createView(),
        ));
    }

    /**
     * Creates a form to delete a contract entity.
     *
     * @param Contract $contract The contract entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Contract $contract)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('contract_delete', array('id' => $contract->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
