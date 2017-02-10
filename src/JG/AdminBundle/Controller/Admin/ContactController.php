<?php

namespace JG\AdminBundle\Controller\Admin;

use JG\CoreBundle\Entity\Contact;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Contact controller.
 *
 * @Route("contact")
 */
class ContactController extends Controller
{
    /**
     * Lists all contact entities.
     *
     * @Route("/", name="contact_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $contacts = $em->getRepository(Contact::class)->findAll();

        $deleteForms = array();

        foreach ($contacts as $contact) {
            $deleteForms[$contact->getId()] = $this->createDeleteForm($contact)->createView();
        }

        return $this->render('JGAdminBundle:Admin:contact/index.html.twig', array(
            'contacts' => $contacts,
            'deleteForms' => $deleteForms
        ));
    }

    /**
     * Moderation contact.
     *
     * @Route("/valid/{id}/state/{state}", name="contact_valid")
     * @Method("GET")
     */
    public function validAction(Request $request, Contact $contact, $state)
    {
        $em = $this->getDoctrine()->getManager();

        $contact->setViewed($state);

        $em->persist($contact);

        $em->flush($contact);

        if ($state)
            $request->getSession()->getFlashBag()->add('success', 'Demande de contact lue avec succès !');
        else
            $request->getSession()->getFlashBag()->add('success', 'Demande de contact non lue avec succès !');

        if ($state)
            return $this->redirectToRoute('contact_show', array('id' => $contact->getId()));
        else
            return $this->redirectToRoute('contact_index');
    }

    /**
     * Finds and displays a contact entity.
     *
     * @Route("/{id}", name="contact_show")
     * @Method("GET")
     */
    public function showAction(Contact $contact)
    {
        $deleteForm = $this->createDeleteForm($contact);

        return $this->render('JGAdminBundle:Admin:contact/show.html.twig', array(
            'contact' => $contact,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a contact entity.
     *
     * @Route("/{id}/delete", name="contact_delete")
     */
    public function deleteAction(Request $request, Contact $contact)
    {
        $form = $this->createDeleteForm($contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $response = $this->get('app.crud.delete')->deleteEntity($contact);

            if ($response)
                $request->getSession()->getFlashBag()->add('success', 'Contact supprimé avec succès !');
            else
                $request->getSession()->getFlashBag()->add('error', 'Erreurs lors de la suppression du contact');

            return $this->redirectToRoute('contact_index');
        }

        return $this->render('JGAdminBundle:Admin:contact/delete.html.twig', array(
            'contact' => $contact,
            'delete_form'  => $form->createView(),
        ));
    }

    /**
     * Creates a form to delete a contact entity.
     *
     * @param Contact $contact The contact entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Contact $contact)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('contact_delete', array('id' => $contact->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
