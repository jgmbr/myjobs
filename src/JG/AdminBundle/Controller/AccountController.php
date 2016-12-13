<?php
/**
 * Created by PhpStorm.
 * User: Justine GAMBIER
 * Date: 12/12/2016
 * Time: 21:02
 */

namespace JG\AdminBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AccountController extends Controller
{
    /**
     * @Route("/account/index", name="account_home_page")
     */
    public function indexAction()
    {
        $user = $this->getUser();

        return $this->render('JGAdminBundle:Account:index.html.twig',array(
            'user' => $user
        ));
    }
}
