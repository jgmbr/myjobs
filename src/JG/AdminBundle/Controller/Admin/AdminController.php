<?php

namespace JG\AdminBundle\Controller\Admin;

use JG\CoreBundle\Entity\Contract;
use JG\CoreBundle\Entity\Status;
use JG\UserBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    /**
     * @Route("/index", name="admin_home_page")
     */
    public function indexAction()
    {
        return $this->render('JGAdminBundle:Admin:index.html.twig',array(
            'user'              => $this->getUser(),
            'nbUsers'           => $this->getDoctrine()->getRepository(User::class)->findCountUsers(),
            'nbAdministrators'  => $this->getDoctrine()->getRepository(User::class)->findCountAdmin(),
            'nbContracts'       => $this->getDoctrine()->getRepository(Contract::class)->findCount(),
            'nbStatus'          => $this->getDoctrine()->getRepository(Status::class)->findCount()
        ));
    }
}