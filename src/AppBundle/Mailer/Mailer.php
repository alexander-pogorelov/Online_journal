<?php
/**
 * Created by PhpStorm.
 * User: Alexander Pogorelov
 * Date: 07.01.2017
 * Time: 13:20
 */

namespace AppBundle\Mailer;

use FOS\UserBundle\Mailer\Mailer as FOSMailer;
use FOS\UserBundle\Model\UserInterface;


class Mailer extends FOSMailer
{
    public function sendResettingEmailMessage(UserInterface $user)
    {
        $template = $this->parameters['resetting.template'];
        // заменяем на нужный маршрут
        $url = $this->router->generate('sonata_user_admin_resetting_reset', array('token' => $user->getConfirmationToken()), true);
        $rendered = $this->templating->render($template, array(
            'user' => $user,
            'confirmationUrl' => $url
        ));
        $this->sendEmailMessage($rendered, $this->parameters['from_email']['resetting'], $user->getEmail());
    }
}