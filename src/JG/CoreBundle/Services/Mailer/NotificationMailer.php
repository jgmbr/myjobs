<?php

namespace JG\CoreBundle\Services\Mailer;

use FOS\UserBundle\Mailer\MailerInterface;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Dump\Container;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Templating\EngineInterface;

class NotificationMailer implements MailerInterface
{
    private $container;

    private $router;

    private $mailer;

    private $templating;

  public function __construct(ContainerInterface $container ,RouterInterface $router, \Swift_Mailer $mailer, EngineInterface $templating)
  {
      $this->container = $container;

    $this->router = $router;

    $this->mailer = $mailer;

    $this->templating = $templating;
  }

  public function sendConfirmationEmailMessage(UserInterface $user)
  {
      $datas = array(
          'subject'     => $this->container->getParameter('fos_user.registration.confirmation.from_email.sender_name'),
          'from'        => $this->container->getParameter('fos_user.registration.confirmation.from_email.address'),
          'to'          => $user->getEmail(),
          'template'    => 'JGUserBundle:Email:registration.html.twig',
          'content'     => array(
              'user' => $user
          ),
          'image'       => null,
          'attachment'  => null
      );

      $this->sendEmailMessage($datas);
  }

  public function sendResettingEmailMessage(UserInterface $user)
  {
      $datas = array(
          'subject'     => $this->container->getParameter('fos_user.resetting.email.from_email.sender_name'),
          'from'        => $this->container->getParameter('fos_user.resetting.email.from_email.address'),
          'to'          => $user->getEmail(),
          'template'    => 'JGUserBundle:Email:resetting.html.twig',
          'content'     => array(
              'user' => $user,
              'resettingUrl' => $this->router->generate('fos_user_resetting_reset', array('token' => $user->getConfirmationToken()), true)
          ),
          'image'       => null,
          'attachment'  => null
      );

      $this->sendEmailMessage($datas);
  }

  public function sendEmailMessage($datas)
  {
      if (!$datas)
          return false;

      $message = \Swift_Message::newInstance()
          ->setSubject($datas['subject'])
          ->setFrom($datas['from'])
          ->setTo($datas['to'])
          ->setBody($this->templating->render($datas['template'],$datas['content']))
          ->setContentType('text/html')
      ;

      if (!empty($datas['image']))
        $message->embed(\Swift_Image::fromPath($datas['image']));

      if (!empty($datas['attachment']))
        $message->attach(\Swift_Attachment::fromPath($datas['attachment']));

      $this->mailer->send($message);
  }
}
