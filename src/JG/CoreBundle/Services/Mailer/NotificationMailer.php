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
    private $router;
    private $mailer;
    private $templating;

  public function __construct(RouterInterface $router, \Swift_Mailer $mailer, EngineInterface $templating)
  {
    $this->router = $router;
    $this->mailer = $mailer;
    $this->templating = $templating;
  }

  public function sendConfirmationEmailMessage(UserInterface $user)
  {
      $datas = array(
          'subject'     => 'MyJobs › Confirmation inscription',
          'from'        => 'gambier.j@gmail.com',
          'to'          => $user->getEmail(),
          'template'    => 'JGUserBundle:Registration:registration.html.twig',
          'content'     => array(
              'user' => $user,
              'confirmationUrl' => $this->router->generate('fos_user_resetting_reset', array('token' => $user->getConfirmationToken()), true)
          ),
          'image'       => null,
          'attachment'  => null
      );

      return $this->sendEmailMessage($datas);
  }

  public function sendResettingEmailMessage(UserInterface $user)
  {
      $datas = array(
          'subject'     => 'MyJobs › Réinitialisation de mot de passe',
          'from'        => 'gambier.j@gmail.com',
          'to'          => $user->getEmail(),
          'template'    => 'JGUserBundle:Resetting:resetting.html.twig',
          'content'     => array(
              'user' => $user,
              'confirmationUrl' => $this->router->generate('fos_user_resetting_reset', array('token' => $user->getConfirmationToken()), true)
          ),
          'image'       => null,
          'attachment'  => null
      );

      return $this->sendEmailMessage($datas);
  }

  public function sendCongratulationsInscription(UserInterface $user)
  {
      $datas = array(
          'subject'     => 'MyJobs › Confirmation inscription',
          'from'        => 'gambier.j@gmail.com',
          'to'          => $user->getEmail(),
          'template'    => 'JGUserBundle:Congratulation:congratulation.html.twig',
          'content'     => array(
              'user' => $user
          ),
          'image'       => null,
          'attachment'  => null
      );

      return $this->sendEmailMessage($datas);
  }

  public function sendEmailMessage($datas)
  {
      if (!$datas)
          return false;

      $message = \Swift_Message::newInstance()
          ->setSubject($datas['subject'])
          ->setFrom($datas['from'])
          ->setTo($datas['to'])
          ->setBody(
              $this->templating->render($datas['template'],$datas['content']), 'text/html'
          )
          ->setContentType('text/html')
      ;

      if (!empty($datas['image']))
        $message->embed(\Swift_Image::fromPath($datas['image']));

      if (!empty($datas['attachment']))
        $message->attach(\Swift_Attachment::fromPath($datas['attachment']));

      if ($this->mailer->send($message))
          return true;
      else
          return false;
  }
}
