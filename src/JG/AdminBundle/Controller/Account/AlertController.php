<?php

namespace JG\AdminBundle\Controller\Account;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Alert controller.
 *
 * @Route("alert")
 */
class AlertController extends Controller
{
    /**
     * Lists all alert entities.
     *
     * @Route("/", name="alert_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();

        return $this->render('JGAdminBundle:Account:alert/index.html.twig', array(

        ));
    }
}
