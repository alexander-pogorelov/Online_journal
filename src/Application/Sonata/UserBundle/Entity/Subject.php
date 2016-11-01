<?php
/**
 * Created by PhpStorm.
 * User: Ксения
 * Date: 24.10.2016
 * Time: 19:07
 */

namespace Application\Sonata\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class Subject
{
    protected $id;

    protected $name;

    protected $abbreviation;

    protected $specialization;

    protected $comment;

    protected $TeacherSubject;

    public function __construct()
    {
        $this->TeacherSubject = new ArrayCollection();
    }


    /**
     * Set name
     *
     * @param string $name
     *
     * @return Subject
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set abbreviation
     *
     * @param string $abbreviation
     *
     * @return Subject
     */
    public function setAbbreviation($abbreviation)
    {
        $this->abbreviation = $abbreviation;

        return $this;
    }

    /**
     * Get abbreviation
     *
     * @return string
     */
    public function getAbbreviation()
    {
        return $this->abbreviation;
    }

    /**
     * Set specialization
     *
     * @param string $specialization
     *
     * @return Subject
     */
    public function setSpecialization($specialization)
    {
        $this->specialization = $specialization;

        return $this;
    }

    /**
     * Get specialization
     *
     * @return string
     */
    public function getSpecialization()
    {
        return $this->specialization;
    }

    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return Subject
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Add teacherSubject
     *
     * @param \Application\Sonata\UserBundle\Entity\TeacherSubject $teacherSubject
     *
     * @return Subject
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

    public function __toString()
    {
        return $this->getName();
    }

    public function getTeachers()
    {
        $teachersArray = array_map(function (TeacherSubject $teacherSubject) {
            return $teacherSubject->getTeacher();
        }, $this->TeacherSubject->toArray());

        return $teachersArray;
    }
}
