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
    private $timeClassroom;

    /**
     * @var \Application\Sonata\UserBundle\Entity\Classroom
     */
    private $dateClassroom;


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
     * Set timeClassroom
     *
     * @param \Application\Sonata\UserBundle\Entity\Timeforclassroom $timeClassroom
     *
     * @return DateTimeClassroom
     */
    public function setTimeClassroom(\Application\Sonata\UserBundle\Entity\Timeforclassroom $timeClassroom = null)
    {
        $this->timeClassroom = $timeClassroom;

        return $this;
    }

    /**
     * Get timeClassroom
     *
     * @return \Application\Sonata\UserBundle\Entity\Timeforclassroom
     */
    public function getTimeClassroom()
    {
        return $this->timeClassroom;
    }

    /**
     * Set dateClassroom
     *
     * @param \Application\Sonata\UserBundle\Entity\Classroom $dateClassroom
     *
     * @return DateTimeClassroom
     */
    public function setDateClassroom(\Application\Sonata\UserBundle\Entity\Classroom $dateClassroom = null)
    {
        $this->dateClassroom = $dateClassroom;

        return $this;
    }

    /**
     * Get dateClassroom
     *
     * @return \Application\Sonata\UserBundle\Entity\Classroom
     */
    public function getDateClassroom()
    {
        return $this->dateClassroom;
    }
}

