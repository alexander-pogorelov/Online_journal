<?php

namespace Application\Sonata\UserBundle\Entity;

use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * TimeInterval
 * @ExclusionPolicy("all")
 */
class TimeInterval
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var \DateTime
     * @Expose()
     */
    private $startTime;

    /**
     * @var \DateTime
     * @Expose()
     */
    private $endTime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set title
     *
     * @param string $title
     *
     * @return TimeInterval
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set startTime
     *
     * @param \DateTime $startTime
     *
     * @return TimeInterval
     */
    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;

        return $this;
    }

    /**
     * Get startTime
     *
     * @return \DateTime
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * Set endTime
     *
     * @param \DateTime $endTime
     *
     * @return TimeInterval
     */
    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;

        return $this;
    }

    /**
     * Get endTime
     *
     * @return \DateTime
     */
    public function getEndTime()
    {
        return $this->endTime;
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

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->getStartTime()->format('H:i').' - '.$this->getEndTime()->format('H:i');
    }

}
