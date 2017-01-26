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

        // Download form

        $form = $this->createForm('JG\CoreBundle\Form\DownloadType', array());

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $datas = $form->getData();

            $generateZip = true;

            $sourceDir = $this->get('kernel')->getRootDir().'/../web/download/csv/';

            $zipDir = $this->get('kernel')->getRootDir().'/../web/download/zip/';

            $start = $datas['start'];

            $end = $datas['end'];

            $all = (sizeof($datas['init']) > 0 ? true : false);

            $options = null;
            if (!$all) {
                $options = array(
                    'start' => $start,
                    'end' => $end
                );
            }

            $types = $datas['type'];

            $exportWS = $this->get('app.export');

            $exportWS->cleanFolder($sourceDir.$user->getId().'/');

            foreach ($types as $type) {

                $headers = null;
                $query = '';
                $csv = '';
                $date = date('YmdHis');

                switch ($type) {
                    case 'application':
                        $entity = 'Application';
                        $headers = array('id','date_at','name','url','contract','state','company','comment','business_reason','people_reason','created_at');
                        $query = 'exportMyApplications';
                        $csv = 'export-applications-'.$date;
                        break;
                    case 'company':
                        $entity = 'Company';
                        $headers = array('id','name','address1','address2','postcode','city','country','email','phone','website','contact','created_at');
                        $query = 'exportMyCompanies';
                        $csv = 'export-companies-'.$date;
                        break;
                    case 'appointment':
                        $entity = 'Appointment';
                        $headers = array('id','name','state','company','date_at','hour_at','comment','created_at');
                        $query = 'exportMyAppointments';
                        $csv = 'export-appointments-'.$date;
                        break;
                }

                $exportWS->export('JGCoreBundle:'.$entity, $query, $options, $headers, $csv, $user, false);

            }

            if ($generateZip) {

                $zipName = 'MyApplications-User-'.$user->getId().'-'.time().'.zip';

                $zip = new \ZipArchive();

                $directory = $sourceDir.$user->getId();

                $link = $zipDir.$zipName;

                $scanned_directory = array_diff(scandir($directory), array('..', '.'));

                $zip->open($link, \ZipArchive::CREATE);

                foreach ($scanned_directory as $key => $value) {
                    if (!$zip->addFile($directory."/".$value, $value)){
                        var_dump('Ajout du fichier '.$value.' impossible');
                    }
                }

                $zip->close();

                return new Response(readfile($link), 200, array(
                    'Content-Type' => 'application/force-download',
                    'Content-Disposition' => 'attachment; filename="'.$zipName.'"'
                ));

            }

        }

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
            'nbAppointmentsCancel'      => $nbAppointmentsCancel,
            'formDownload'              => $form->createView()
        ));
    }
}
