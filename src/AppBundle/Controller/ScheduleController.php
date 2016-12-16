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

            $weekdays = Schedule::getWeekdays();
            $parameters['weekdays'] = $weekdays;
        }

        return parent::render($view, $parameters, $response); // TODO: Change the autogenerated stub
    }
}