<?php

namespace Application\Sonata\UserBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 *@UniqueEntity(
 *     "number",
 *     message="Аудитория с таким номером уже существует."
 * )
 * @ExclusionPolicy("all")
 */
class Classroom
{
    /**
     * @var integer
     * @Expose()
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
        return $this->getName();
    }

    public function getName()
    {
        return 'а.'.(string)$this->getNumber() ;
    }

}
