<?php

namespace JG\AdminBundle\Controller\Account;

use JG\CoreBundle\Entity\Preference;
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

        $preference = $em->getRepository('JGCoreBundle:Preference')->findOneByUser($user);

        if (!$preference) {
            $preference = new Preference();
            $form = $this->createForm('JG\CoreBundle\Form\PreferenceType', $preference);
        } else {
            $form = $this->createForm('JG\CoreBundle\Form\PreferenceType', $preference);
        }

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $preference->setUser($user);
            $user->addPreference($preference);
            $em->persist($preference);
            $em->flush($preference);
            $request->getSession()->getFlashBag()->add('success', 'Préférences enregistrées avec succès !');
            return $this->redirectToRoute('preference_index');
        }

        return $this->render('JGAdminBundle:Account:preference/index.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
