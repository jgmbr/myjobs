<?php

namespace JG\CoreBundle\Services\Mailer;

use FOS\UserBundle\Mailer\MailerInterface;
use FOS\UserBundle\Model\UserInterface;
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
          'from'        => 'contact@justine-gambier.fr',
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
      $url = $this->router->generate('fos_user_resetting_reset', array('token' => $user->getConfirmationToken()), true);

      $datas = array(
          'subject'     => 'MyJobs › Réinitialisation de mot de passe',
          'from'        => 'contact@justine-gambier.fr',
          'to'          => $user->getEmail(),
          'template'    => 'JGUserBundle:Email:resetting.html.twig',
          'content'     => array(
              'user' => $user,
              'resettingUrl' => $url
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
