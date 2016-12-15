<?php

namespace AppBundle\Controller;

use Application\Sonata\UserBundle\Entity\Schedule;
use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\Response;
use Application\Sonata\UserBundle\Entity\TimeInterval;
class ScheduleController extends Controller
{
    public function render($view, array $parameters = array(), Response $response = null)
    {

        if ($parameters['action'] === 'list'){
            $em = $this->getDoctrine()->getManager();

            $teachers = $em->getRepository('ApplicationSonataUserBundle:Schedule')->getDistinctTeachers();
            $parameters['teachers'] = $teachers;

            $groups = $em->getRepository('ApplicationSonataUserBundle:Schedule')->getDistinctGroups();
            $parameters['groups'] = $groups;

            $classrooms = $em->getRepository('ApplicationSonataUserBundle:Schedule')->getDistinctClassrooms();
            $parameters['classrooms'] = $classrooms;

            $timeIntervals = $em->getRepository('ApplicationSonataUserBundle:TimeInterval')->findAll();
            $parameters['timeintervals'] = $timeIntervals;

            $parameters['scheduleKeysArray'] = $em->getRepository('ApplicationSonataUserBundle:Schedule')->scheduleKeysArray();

            $weekdays = [
                '1' => ['short' => 'ПН', 'full' => 'Понедельник'],
                '2' => ['short' => 'ВТ', 'full' => 'Вторник'],
                '3' => ['short' => 'СР', 'full' => 'Среда'],
                '4' => ['short' => 'ЧТ', 'full' => 'Четверг'],
                '5' => ['short' => 'ПТ', 'full' => 'Пятница'],
                '6' => ['short' => 'СБ', 'full' => 'Суббота'],
                '0' => ['short' => 'ВС', 'full' => 'Воскресенье'],
            ];
            $parameters['weekdays'] = $weekdays;
        }

        return parent::render($view, $parameters, $response); // TODO: Change the autogenerated stub
    }
}