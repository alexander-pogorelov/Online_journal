<?php

namespace AppBundle\Controller;

use Application\Sonata\UserBundle\ApplicationSonataUserBundle;
use Application\Sonata\UserBundle\Entity\GroupIteen;
use Sonata\AdminBundle\Controller\CoreController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ScheduleController extends CoreController
{
    public function listAction()
    {
        $weekdays = ['ПН','ВТ','СР','ЧТ','ПТ','СБ','ВС'];
        $timeIntervals = ['9.00-10.20','13.30-14.50','15.00-16.20','16.30-17.50'];
        $link = 'http://s3pjo0.axshare.com/#p=%D1%80%D0%B0%D1%81%D0%BF%D0%B8%D1%81%D0%B0%D0%BD%D0%B8%D1%8F';

       /* if (false === $this->admin->isGranted('LIST')) {
            throw new AccessDeniedException();
        }*/

        //... use any methods or services to get statistics data

        $em = $this->getDoctrine()->getManager();
        $groups = $em->getRepository('ApplicationSonataUserBundle:GroupIteen')->findAll();

        $name = 'Расписание';

       return $this->render('AppBundle:ScheduleAdmin:schedule_list.html.twig', array(
                    'name'  => $name,
                    'groups'=> $groups,
                    'weekdays'=>$weekdays,
                    'timeIntervals'=>$timeIntervals,
                    'link'=>$link
                ));
    }
}