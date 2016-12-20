<?php

namespace Application\Sonata\UserBundle\Repository;
use Application\Sonata\UserBundle\Entity\Schedule;

/**
 * ClassroomRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ScheduleRepository extends \Doctrine\ORM\EntityRepository
{
    //возвращает преобразованый массив данных расписания с тремя ключали для проверки при выводе расписания
    public function scheduleKeysArray(){
        $schedule = $this->findAll();
        if ($schedule){
            foreach ($schedule as $lesson){
                $weekday = $lesson->getWeekday();
                $timeinterval = $lesson->getTimeinterval()->getId();
                $classroom = (string)$lesson->getClassroom();
                $group = (string)$lesson->getGroup()->getGroupName();
                $teacher = $lesson->getTeacher()->getId();
                $sortScheduleKey[$weekday][$timeinterval][$teacher] = $lesson;
                $sortScheduleKey[$weekday][$timeinterval][$group] = $lesson;
                $sortScheduleKey[$weekday][$timeinterval][$classroom] = $lesson;
                }
        } else $sortScheduleKey = array();

        return $sortScheduleKey;
    }

    public function getDistinctTeachers()
    {
        $teachers = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('u')
            ->from($this->_entityName, 'u')
            ->groupBy('u.teacher')
            ->getQuery()->getResult();

        return $teachers;
    }

    public function getDistinctGroups()
    {
        $groups = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('u')
            ->from('ApplicationSonataUserBundle:Schedule', 'u')
            ->groupBy('u.group')
            ->getQuery()->getResult();

        return $groups;
    }

    public function getDistinctClassrooms()
    {
        $classrooms =  $this->getEntityManager()
            ->createQueryBuilder()
            ->select('u')
            ->from('ApplicationSonataUserBundle:Schedule', 'u')
            ->groupBy('u.classroom')
            ->getQuery()->getResult();

        return $classrooms;
    }
}
