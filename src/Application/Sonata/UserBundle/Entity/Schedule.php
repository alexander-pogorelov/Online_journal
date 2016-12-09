<?php

namespace Application\Sonata\UserBundle\Entity;

/**
 * Schedule
 */
class Schedule
{
    /**
     * @var integer
     */
    private $weekday;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Application\Sonata\UserBundle\Entity\GroupIteen
     */
    private $group;

    /**
     * @var \Application\Sonata\UserBundle\Entity\User
     */
    private $teacher;

    /**
     * @var \Application\Sonata\UserBundle\Entity\Subject
     */
    private $subject;

    /**
     * @var \Application\Sonata\UserBundle\Entity\TimeInterval
     */
    private $timeinterval;

    /**
     * @var \Application\Sonata\UserBundle\Entity\Classroom
     */
    private $classroom;


    /**
     * Set weekday
     *
     * @param integer $weekday
     *
     * @return Schedule
     */
    public function setWeekday($weekday)
    {
        $this->weekday = $weekday;

        return $this;
    }

    /**
     * Get weekday
     *
     * @return integer
     */
    public function getWeekday()
    {
        $weekdays = [
            'ВС' , 'ПН' ,
            'ВТ' , 'СР' ,
            'ЧТ' , 'ПТ' , 'СБ'
        ];
        if ($this->getId()){
            return $weekdays[$this->weekday];
        }
        return $this->weekday;
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
     * Set group
     *
     * @param \Application\Sonata\UserBundle\Entity\GroupIteen $group
     *
     * @return Schedule
     */
    public function setGroup(\Application\Sonata\UserBundle\Entity\GroupIteen $group = null)
    {
        $this->group = $group;

        return $this;
    }

    /**
     * Get group
     *
     * @return \Application\Sonata\UserBundle\Entity\GroupIteen
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * Set teacher
     *
     * @param \Application\Sonata\UserBundle\Entity\UserTeacher $teacher
     *
     * @return Schedule
     */
    public function setTeacher(\Application\Sonata\UserBundle\Entity\UserTeacher $teacher = null)
    {
        $this->teacher = $teacher;

        return $this;
    }

    /**
     * Get teacher
     *
     * @return \Application\Sonata\UserBundle\Entity\User
     */
    public function getTeacher()
    {
        return $this->teacher;
    }

    /**
     * Set subject
     *
     * @param \Application\Sonata\UserBundle\Entity\Subject $subject
     *
     * @return Schedule
     */
    public function setSubject(\Application\Sonata\UserBundle\Entity\Subject $subject = null)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return \Application\Sonata\UserBundle\Entity\Subject
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set timeinterval
     *
     * @param \Application\Sonata\UserBundle\Entity\TimeInterval $timeinterval
     *
     * @return Schedule
     */
    public function setTimeinterval(\Application\Sonata\UserBundle\Entity\TimeInterval $timeinterval = null)
    {
        $this->timeinterval = $timeinterval;

        return $this;
    }

    /**
     * Get timeinterval
     *
     * @return \Application\Sonata\UserBundle\Entity\TimeInterval
     */
    public function getTimeinterval()
    {
        return $this->timeinterval;
    }

    /**
     * Set classroom
     *
     * @param \Application\Sonata\UserBundle\Entity\Classroom $classroom
     *
     * @return Schedule
     */
    public function setClassroom(\Application\Sonata\UserBundle\Entity\Classroom $classroom = null)
    {
        $this->classroom = $classroom;

        return $this;
    }

    /**
     * Get classroom
     *
     * @return \Application\Sonata\UserBundle\Entity\Classroom
     */
    public function getClassroom()
    {
        return $this->classroom;
    }
}

