<?php

namespace JG\AdminBundle\Controller\Admin;

use JG\CoreBundle\Entity\Application;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Application controller.
 *
 * @Route("application")
 */
class AdminApplicationController extends Controller
{
    /**
     * Lists all application entities.
     *
     * @Route("/", name="application_list")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $applications = $em->getRepository('JGCoreBundle:Application')->findAll();

        return $this->render('JGAdminBundle:Admin:application/index.html.twig', array(
            'applications' => $applications,
        ));
    }

    /**
     * Finds and displays a application entity.
     *
     * @Route("/{id}", name="application_list_show")
     * @Method("GET")
     */
    public function showAction(Application $application)
    {
        return $this->render('JGAdminBundle:Admin:application/show.html.twig', array(
            'application' => $application
        ));
    }

}
