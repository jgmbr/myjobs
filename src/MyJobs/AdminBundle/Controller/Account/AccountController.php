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

        return $this->render('MyJobsAdminBundle:Account:index.html.twig',array(
            'user' => $user
        ));
    }
}
