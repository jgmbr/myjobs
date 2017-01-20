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
class StatisticController extends Controller
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

        // Companies

        $nbCompanies = $em->getRepository('JGCoreBundle:Company')->countMyCompanies($user);

        // Applications

        $nbApplications = $em->getRepository('JGCoreBundle:Application')->countMyApplications($user);

        $inprogress = $em->getRepository('JGCoreBundle:Status')->findByName('En cours');

        $valided = $em->getRepository('JGCoreBundle:Status')->findByName('Validée');

        $refused = $em->getRepository('JGCoreBundle:Status')->findByName('Refusée');

        $nbApplicationsInProgress = $em->getRepository('JGCoreBundle:Application')->countMyApplicationsWithStatus($user, $inprogress);

        $nbApplicationsValided = $em->getRepository('JGCoreBundle:Application')->countMyApplicationsWithStatus($user, $valided);

        $nbApplicationsRefused = $em->getRepository('JGCoreBundle:Application')->countMyApplicationsWithStatus($user, $refused);

        $cdi = $em->getRepository('JGCoreBundle:Contract')->findByName('CDI');

        $cdd = $em->getRepository('JGCoreBundle:Contract')->findByName('CDD');

        $stage = $em->getRepository('JGCoreBundle:Contract')->findByName('Stage');

        $nbApplicationsCDI = $em->getRepository('JGCoreBundle:Application')->countMyApplicationsWithStatus($user, $cdi);

        $nbApplicationsCDD = $em->getRepository('JGCoreBundle:Application')->countMyApplicationsWithStatus($user, $cdd);

        $nbApplicationsStage = $em->getRepository('JGCoreBundle:Application')->countMyApplicationsWithStatus($user, $stage);

        // Appointments

        $nbAppointments = $em->getRepository('JGCoreBundle:Appointment')->countMyAppointments($user);

        $confirmed = $em->getRepository('JGCoreBundle:State')->findByName('Confirmé');

        $wait = $em->getRepository('JGCoreBundle:State')->findByName('En attente');

        $cancel = $em->getRepository('JGCoreBundle:State')->findByName('Annulé');

        $nbAppointmentsConfirmed = $em->getRepository('JGCoreBundle:Appointment')->countMyAppointmentsWithState($user, $confirmed);

        $nbAppointmentsWait = $em->getRepository('JGCoreBundle:Appointment')->countMyAppointmentsWithState($user, $wait);

        $nbAppointmentsCancel = $em->getRepository('JGCoreBundle:Appointment')->countMyAppointmentsWithState($user, $cancel);

        // View

        return $this->render('JGAdminBundle:Account:statistic/index.html.twig', array(
            'nbCompanies'               => $nbCompanies,
            'nbApplications'            => $nbApplications,
            'nbApplicationsInProgress'  => $nbApplicationsInProgress,
            'nbApplicationsValided'     => $nbApplicationsValided,
            'nbApplicationsRefused'     => $nbApplicationsRefused,
            'nbApplicationsCDI'         => $nbApplicationsCDI,
            'nbApplicationsCDD'         => $nbApplicationsCDD,
            'nbApplicationsStage'       => $nbApplicationsStage,
            'nbAppointments'            => $nbAppointments,
            'nbAppointmentsConfirmed'   => $nbAppointmentsConfirmed,
            'nbAppointmentsWait'        => $nbAppointmentsWait,
            'nbAppointmentsCancel'      => $nbAppointmentsCancel
        ));
    }
}
