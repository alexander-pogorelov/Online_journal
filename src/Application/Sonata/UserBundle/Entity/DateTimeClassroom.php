<?php

namespace Application\Sonata\UserBundle\Entity;

/**
 * DateTimeClassroom
 */
class DateTimeClassroom
{
    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Application\Sonata\UserBundle\Entity\Timeforclassroom
     */
    private $time_id;

    /**
     * @var \Application\Sonata\UserBundle\Entity\Classroom
     */
    private $classroom_id;


    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return DateTimeClassroom
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
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
     * Set timeId
     *
     * @param \Application\Sonata\UserBundle\Entity\Timeforclassroom $timeId
     *
     * @return DateTimeClassroom
     */
    public function setTimeId(\Application\Sonata\UserBundle\Entity\Timeforclassroom $timeId = null)
    {
        $this->time_id = $timeId;

        return $this;
    }

    /**
     * Get timeId
     *
     * @return \Application\Sonata\UserBundle\Entity\Timeforclassroom
     */
    public function getTimeId()
    {
        return $this->time_id;
    }

    /**
     * Set classroomId
     *
     * @param \Application\Sonata\UserBundle\Entity\Classroom $classroomId
     *
     * @return DateTimeClassroom
     */
    public function setClassroomId(\Application\Sonata\UserBundle\Entity\Classroom $classroomId = null)
    {
        $this->classroom_id = $classroomId;

        return $this;
    }

    /**
     * Get classroomId
     *
     * @return \Application\Sonata\UserBundle\Entity\Classroom
     */
    public function getClassroomId()
    {
        return $this->classroom_id;
    }
}

