<?php

namespace JG\AdminBundle\Controller\Account;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

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
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();

        // Download form

        $form = $this->createForm('JG\CoreBundle\Form\DownloadType', array());

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $datas = $form->getData();

            $zipWS = $this->get('app.zip');

            return $zipWS->generate($datas);

        }

        // View

        return $this->render('JGAdminBundle:Account:statistic/index.html.twig', array(
            'nbCompanies'               => $em->getRepository('JGCoreBundle:Company')->countMyCompanies($user),
            'nbApplications'            => $em->getRepository('JGCoreBundle:Application')->countMyApplications($user),
            'nbApplicationsInProgress'  => $em->getRepository('JGCoreBundle:Application')->countMyApplicationsWithStatus($user, $em->getRepository('JGCoreBundle:Status')->findByName('En cours')),
            'nbApplicationsValided'     => $em->getRepository('JGCoreBundle:Application')->countMyApplicationsWithStatus($user, $em->getRepository('JGCoreBundle:Status')->findByName('Validée')),
            'nbApplicationsRefused'     => $em->getRepository('JGCoreBundle:Application')->countMyApplicationsWithStatus($user, $em->getRepository('JGCoreBundle:Status')->findByName('Refusée')),
            'nbApplicationsCDI'         => $em->getRepository('JGCoreBundle:Application')->countMyApplicationsWithStatus($user, $em->getRepository('JGCoreBundle:Contract')->findByName('CDI')),
            'nbApplicationsCDD'         => $em->getRepository('JGCoreBundle:Application')->countMyApplicationsWithStatus($user, $em->getRepository('JGCoreBundle:Contract')->findByName('CDD')),
            'nbApplicationsStage'       => $em->getRepository('JGCoreBundle:Application')->countMyApplicationsWithStatus($user, $em->getRepository('JGCoreBundle:Contract')->findByName('Stage')),
            'nbAppointments'            => $em->getRepository('JGCoreBundle:Appointment')->countMyAppointments($user),
            'nbAppointmentsConfirmed'   => $em->getRepository('JGCoreBundle:Appointment')->countMyAppointmentsWithState($user, $em->getRepository('JGCoreBundle:State')->findByName('Confirmé')),
            'nbAppointmentsWait'        => $em->getRepository('JGCoreBundle:Appointment')->countMyAppointmentsWithState($user, $em->getRepository('JGCoreBundle:State')->findByName('En attente')),
            'nbAppointmentsCancel'      => $em->getRepository('JGCoreBundle:Appointment')->countMyAppointmentsWithState($user, $em->getRepository('JGCoreBundle:State')->findByName('Annulé')),
            'formDownload'              => $form->createView()
        ));
    }
}
