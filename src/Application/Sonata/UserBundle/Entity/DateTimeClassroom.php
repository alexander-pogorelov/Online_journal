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
     * @var \Application\Sonata\UserBundle\Entity\TimeInterval
     */
    private $time;

    /**
     * @var \Application\Sonata\UserBundle\Entity\Classroom
     */
    private $classroom;


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
     * Set time
     *
     * @param \Application\Sonata\UserBundle\Entity\TimeInterval $time
     *
     * @return DateTimeClassroom
     */
    public function setTime(\Application\Sonata\UserBundle\Entity\TimeInterval $time = null)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * Get time
     *
     * @return \Application\Sonata\UserBundle\Entity\TimeInterval
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set classroom
     *
     * @param \Application\Sonata\UserBundle\Entity\Classroom $classroom
     *
     * @return DateTimeClassroom
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
