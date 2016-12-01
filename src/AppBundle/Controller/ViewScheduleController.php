<?php

namespace AppBundle\Controller;

use Application\Sonata\UserBundle\ApplicationSonataUserBundle;
use Application\Sonata\UserBundle\Entity\GroupIteen;
use Application\Sonata\UserBundle\Entity\UserTeacher;
use Application\Sonata\UserBundle\Entity\Classroom;
use Sonata\AdminBundle\Controller\CoreController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ViewScheduleController extends CoreController
{
    public  function listMomAction($id){
        $em = $this->getDoctrine()->getManager();
        $subjects = $em->getRepository('ApplicationSonataUserBundle:GroupIteen')->find($id);
        if ($subjects){
            $vill = $subjects->getSubjects()->getValues();
            die($vill);
        } else {
            $vill = null;
        }

        $responce = new JsonResponse();
        return $responce->setData($vill);
    }
    public function listAction()
    {
        $weekdays = ['ПН','ВТ','СР','ЧТ','ПТ','СБ','ВС'];
        $timeIntervals = ['9.00-10.20','13.30-14.50','15.00-16.20','16.30-17.50'];

        $em = $this->getDoctrine()->getManager();
        $groups = $em->getRepository('ApplicationSonataUserBundle:GroupIteen')->findAll();
        $teachers = $em->getRepository('ApplicationSonataUserBundle:UserTeacher')->findAll();
        $classrooms = $em->getRepository('ApplicationSonataUserBundle:Classroom')->findAll();
        $name = 'Расписание';

       return $this->render('AppBundle:ViewScheduleAdmin:view_schedule_list.html.twig', array(
                    'name'  => $name,
                    'groups'=> $groups,
                    'weekdays'=>$weekdays,
                    'timeIntervals'=>$timeIntervals,
                    'teachers'=>$teachers,
                    'classrooms'=>$classrooms
                ));
    }
}