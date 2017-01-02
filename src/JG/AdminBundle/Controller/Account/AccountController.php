<?php
/**
 * Created by PhpStorm.
 * User: Justine GAMBIER
 * Date: 12/12/2016
 * Time: 21:02
 */

namespace JG\AdminBundle\Controller\Account;

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

        $myLastApplications = $em->getRepository('JGCoreBundle:Application')->findMyLastApplications($this->getUser());

        $myLastCompanies = $em->getRepository('JGCoreBundle:Company')->findMyLastCompanies($this->getUser());

        $myLastAppointments = null;

        $nbApplications = $em->getRepository('JGCoreBundle:Application')->countMyApplications($this->getUser());

        $nbCompanies = $em->getRepository('JGCoreBundle:Company')->countMyCompanies($this->getUser());

        $nbAppointments = 0;

        return $this->render('JGAdminBundle:Account:index.html.twig',array(
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
