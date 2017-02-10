<?php

namespace JG\AdminBundle\Controller\Account;

use JG\CoreBundle\Entity\Preference;
use JG\CoreBundle\Form\PreferenceType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Company controller.
 *
 * @Route("preference")
 */
class PreferenceController extends Controller
{
    /**
     * Lists all preferences entities.
     *
     * @Route("/", name="preference_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();

        $preference = $em->getRepository(Preference::class)->findOneByUser($user);

        if (!$preference) {
            $preference = new Preference();
        }

        $form = $this->createForm(PreferenceType::class, $preference);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $response = $this->get('app.crud.create')->createPreference($preference, $user);

            if ($response)
                $request->getSession()->getFlashBag()->add('success', 'Préférences ajoutées avec succès !');
            else
                $request->getSession()->getFlashBag()->add('error', 'Erreur lors de l\'ajout des préférences !');

            return $this->redirectToRoute('preference_index');
        }

        return $this->render('JGAdminBundle:Account:preference/index.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
