<?php

namespace JG\AdminBundle\Controller\Account;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Statistic controller.
 *
 * @Route("statistic")
 */
class AccountStatisticController extends Controller
{
    /**
     * Lists all statistics.
     *
     * @Route("/", name="statistic_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();

        $nbCompanies = $em->getRepository('JGCoreBundle:Company')->countMyCompanies($user);

        $nbApplications = $em->getRepository('JGCoreBundle:Application')->countMyApplications($user);

        $nbAppointments = $em->getRepository('JGCoreBundle:Appointment')->countMyAppointments($user);

        return $this->render('JGAdminBundle:Account:statistic/index.html.twig', array(
            'nbCompanies'       => $nbCompanies,
            'nbApplications'    => $nbApplications,
            'nbAppointments'    => $nbAppointments
        ));
    }
}
