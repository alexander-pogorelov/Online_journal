<?php

namespace Application\Sonata\UserBundle\Entity;

/**
 * Classroom
 */
class Classroom
{
    /**
     * @var integer
     */
    private $number;

    /**
     * @var integer
     */
    private $capacity;

    /**
     * @var string
     */
    private $description;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set number
     *
     * @param integer $number
     *
     * @return Classroom
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return integer
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set capacity
     *
     * @param integer $capacity
     *
     * @return Classroom
     */
    public function setCapacity($capacity)
    {
        $this->capacity = $capacity;

        return $this;
    }

    /**
     * Get capacity
     *
     * @return integer
     */
    public function getCapacity()
    {
        return $this->capacity;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Classroom
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
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
        return 'а.'.(string)$this->getNumber();
    }

}
