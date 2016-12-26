<?php
/**
 * Created by PhpStorm.
 * User: Igor Kachinskiy
 * Date: 17.10.2016
 * Time: 17:27
 */

namespace Application\Sonata\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * @ExclusionPolicy("all")
 */
class UserTeacher extends UserEmployee
{
    protected $TeacherSubject;

    public function __construct() {
        parent::__construct();
        $this->TeacherSubject = new ArrayCollection();
    }


    /**
     * Add teacherSubject
     *
     * @param \Application\Sonata\UserBundle\Entity\TeacherSubject $teacherSubject
     *
     * @return UserTeacher
     */
    public function addTeacherSubject(TeacherSubject $teacherSubject)
    {
        $this->TeacherSubject->add($teacherSubject);;

        return $this;
    }

    /**
     * Remove teacherSubject
     *
     * @param \Application\Sonata\UserBundle\Entity\TeacherSubject $teacherSubject
     */
    public function removeTeacherSubject(TeacherSubject $teacherSubject)
    {
        $this->TeacherSubject->removeElement($teacherSubject);
    }

    /**
     * Get teacherSubject
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTeacherSubject()
    {
        return $this->TeacherSubject;
    }

    public function setTeacherSubject(TeacherSubject $teacherSubject)
    {
        $this->teacherSubject = $teacherSubject;
    }

    public function getSubjects()
    {
        $subjectArray = array_map(function (TeacherSubject $teacherSubject) {
            return $teacherSubject->getSubject();
        }, $this->TeacherSubject->toArray());

        return implode(', ', $subjectArray);
    }
}
