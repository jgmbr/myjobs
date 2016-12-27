<?php
/**
 * Created by PhpStorm.
 * User: Justine GAMBIER
 * Date: 12/12/2016
 * Time: 21:02
 */

namespace MyJobs\AdminBundle\Controller\Account;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AccountController extends Controller
{
    /**
     * @Route("/index", name="account_home_page")
     */
    public function indexAction()
    {
        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();

        $myLastApplications = $em->getRepository('MyJobsCoreBundle:Application')->findMyLastApplications($this->getUser());

        $myLastCompanies = $em->getRepository('MyJobsCoreBundle:Company')->findMyLastCompanies($this->getUser());

        $myLastAppointments = null;

        $nbApplications = $em->getRepository('MyJobsCoreBundle:Application')->countMyApplications($this->getUser());

        $nbCompanies = $em->getRepository('MyJobsCoreBundle:Company')->countMyCompanies($this->getUser());

        $nbAppointments = 0;

        return $this->render('MyJobsAdminBundle:Account:index.html.twig',array(
            'user'                  => $user,
            'myLastApplications'    => $myLastApplications,
            'myLastCompanies'       => $myLastCompanies,
            'myLastAppointments'    => $myLastAppointments,
            'nbApplications'        => $nbApplications,
            'nbCompanies'           => $nbCompanies,
            'nbAppointments'        => $nbAppointments
        ));
    }
}
