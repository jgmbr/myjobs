<?php

namespace JG\AdminBundle\Controller\Account;

use JG\CoreBundle\Entity\Preferences;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Ajax controller.
 *
 * @Route("ajax")
 */
class AjaxController extends Controller
{
    /**
     * @Route("/save/preferences", name="ajax_save_preferences")
     * @Method("POST")
     */
    public function savePreferencesAction(Request $request)
    {
        if (!$request->isXmlHttpRequest()) {
            return new JsonResponse(array('message' => 'You can access this only using Ajax!'), 400);
        }

        $user = $this->getUser();

        $preferences = new Preferences();
        $form = $this->createForm('JG\CoreBundle\Form\PreferencesType', $preferences, array('current_user' => $user));
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $user->addPreference($preferences);

            $em->persist($preferences);
            $em->flush($preferences);

            return new JsonResponse(array('message' => 'Success'), 200);
        }

        $response = new JsonResponse(
            array(
                'message'   => 'Error',
                'form'      => $form->createView()
            )
        , 400);

        return $response;
    }
}
