<?php

namespace AppBundle\Controller;

use Application\Sonata\UserBundle\Entity\GroupIteen;
use Application\Sonata\UserBundle\Entity\UserTeacher;
use Application\Sonata\UserBundle\Entity\Classroom;
use Sonata\AdminBundle\Controller\CoreController;
use Symfony\Component\HttpFoundation\Response;

class ViewScheduleController extends CoreController
{
    public  function ajaxGroupsAction($groupId){
        $html = '';
        $em = $this->getDoctrine()->getManager();

        $group = $em->getRepository('ApplicationSonataUserBundle:GroupIteen')->find($groupId);
        $subjects  =$group->getSubjects();
        if ($subjects){
            foreach($subjects as $sub){
                $html .= '<option value="'.$sub->getId().'" >'.$sub->getName().'</option>';
            }
        }

        return new Response($html, 200);
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