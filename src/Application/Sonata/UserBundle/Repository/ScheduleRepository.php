<?php

namespace Application\Sonata\UserBundle\Repository;

/**
 * ClassroomRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ScheduleRepository extends \Doctrine\ORM\EntityRepository
{
    public function getDistinctTeachers()
    {
        $teachersArray = $this->getEntityManager()
            ->createQuery("SELECT DISTINCT u.id, u.firstname, u.lastname, u.patronymic FROM ApplicationSonataUserBundle:Schedule a JOIN a.teacher u")
            ->getResult();
        $teachers = array_map(function ($teacher) {
            $add["id"] = $teacher["id"];
            $add["fullname"] = $teacher["lastname"].' '.$teacher["firstname"].' '.$teacher["patronymic"];
            return $add;
        }, $teachersArray);
        return $teachers;
    }
    public function getDistinctGroups()
    {
        $groupsArray = $this->getEntityManager()
            ->createQuery("SELECT DISTINCT u.id, u.groupName FROM ApplicationSonataUserBundle:Schedule a JOIN a.group u")
            ->getResult();
        $groups = array_map(function ($group) {
            $add["id"] = $group["id"];
            $add["number"] = $group["groupName"];
            return $add;
        }, $groupsArray);
        return $groups;
    }
    public function getDistinctClassrooms()
    {
        $classroomsArray = $this->getEntityManager()
            ->createQuery("SELECT DISTINCT u.id, u.number FROM ApplicationSonataUserBundle:Schedule a JOIN a.classroom u")
            ->getResult();
        $classrooms = array_map(function ($classroom) {
            $add["id"] = $classroom["id"];
            $add["number"] = 'а.'.$classroom["number"];
            return $add;
        }, $classroomsArray);
        return $classrooms;
    }
}
