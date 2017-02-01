<?php
/**
 * Created by PhpStorm.
 * User: Justine GAMBIER
 * Date: 01/02/2017
 * Time: 14:33
 */

namespace JG\CoreBundle\Services\Zip;

use Doctrine\ORM\EntityManagerInterface;
use JG\CoreBundle\Entity\Application;
use JG\CoreBundle\Entity\Appointment;
use JG\CoreBundle\Entity\Company;
use JG\CoreBundle\Services\Export\ExportDatas;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ZipDatas
{
    private $em;
    private $tokenStorage;
    private $exportWS;
    private $csvDir;
    private $zipDir;
    private $generateZip;
    private $extension;

    public function __construct(EntityManagerInterface $em, TokenStorageInterface $tokenStorage, ExportDatas $exportWS, $csvDir, $zipDir, $generateZip, $extensionZip)
    {
        $this->em               = $em;
        $this->tokenStorage     = $tokenStorage;
        $this->exportWS         = $exportWS;
        $this->csvDir           = $csvDir;
        $this->zipDir           = $zipDir;
        $this->generateZip      = $generateZip;
        $this->extension        = $extensionZip;
    }

    public function generate($datas)
    {
        $user = $this->tokenStorage->getToken()->getUser();

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

        $this->exportWS->cleanFolder($this->csvDir.$user->getId().'/');

        foreach ($types as $type) {

            $headers = null;
            $query =  $csv = $entity = '';
            $date = date('YmdHis');

            switch ($type) {
                case 'application':
                    $entity = new Application();
                    $headers = array('id','date_at','name','url','contract','state','company','comment','business_reason','people_reason','created_at');
                    $query = 'exportMyApplications';
                    $csv = 'export-applications-'.$date;
                    break;
                case 'company':
                    $entity = new Company();
                    $headers = array('id','name','address1','address2','postcode','city','country','email','phone','website','contact','created_at');
                    $query = 'exportMyCompanies';
                    $csv = 'export-companies-'.$date;
                    break;
                case 'appointment':
                    $entity = new Appointment();
                    $headers = array('id','name','state','company','date_at','hour_at','comment','created_at');
                    $query = 'exportMyAppointments';
                    $csv = 'export-appointments-'.$date;
                    break;
            }

            $this->exportWS->export($entity, $query, $options, $headers, $csv, $user, false);

        }

        if ($this->generateZip) {

            $zipName = 'MyApplications-User-'.$user->getId().'-'.time().$this->extension;

            $zip = new \ZipArchive();

            $directory = $this->csvDir.$user->getId();

            $link = $this->zipDir.$zipName;

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
}
