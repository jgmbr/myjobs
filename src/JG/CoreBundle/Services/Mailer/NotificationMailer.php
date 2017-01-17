<?php

namespace JG\CoreBundle\Services\Mailer;

use Symfony\Component\Templating\EngineInterface;

class NotificationMailer
{
    private $mailer;

    private $templating;

  public function __construct(\Swift_Mailer $mailer, EngineInterface $templating)
  {
    $this->mailer = $mailer;

    $this->templating = $templating;
  }

  public function sendEmail($datas)
  {
      /* Exemple of use in a controller

        $serviceNotificationMailer = $this->get('app.mailer');

        $serviceNotificationMailer->sendEmail(
            array(
                'subject'       => 'Musée du Louvre › Confirmation de commande',
                'from'          => $this->getParameter('from_mailer'),
                'to'            => $currentBooking->getEmail(),
                'template'      => 'AppBundle:Ticket:sendtickets.html.twig',
                'content'       => array('codeBooking' => $currentBooking->getCodeBooking(),'listTickets' => $listTickets,'currentBooking' => $currentBooking),
                'image'         => '../web/img/louvre.png',
                'attachment'    => $this->getParameter('path_pdf').$token.'-'.$currentBooking->getCodeBooking().'.pdf'
            )
        );

      */

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

      if ($this->mailer->send($message))
          return true;
      else
          return false;

  }
}
