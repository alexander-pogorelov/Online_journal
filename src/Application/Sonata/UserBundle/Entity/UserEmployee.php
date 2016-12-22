<?php
/**
 * Created by PhpStorm.
 * User: Igor Kachinskiy
 * Date: 19.10.2016
 * Time: 15:25
 */

namespace Application\Sonata\UserBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * @ExclusionPolicy("all")
 */
class UserEmployee extends User
{
    /**
     * @Assert\NotBlank()
     */
    protected $speciality;

    /**
     * @Assert\NotBlank()
     */

    protected $workDays;

    /**
     * @Assert\NotBlank()
     */
    protected $workHours;

    /**
     * Set speciality
     *
     * @param string $speciality
     *
     * @return UserEmployee
     */
    public function setSpeciality($speciality)
    {
        $this->speciality = $speciality;

        return $this;
    }

    /**
     * Get speciality
     *
     * @return string
     */
    public function getSpeciality()
    {
        return $this->speciality;
    }

    /**
     * Set workDays
     *
     * @param string $workDays
     *
     * @return UserEmployee
     */
    public function setWorkDays($workDays)
    {
        $this->workDays = $workDays;

        return $this;
    }

    /**
     * Get workDays
     *
     * @return string
     */
    public function getWorkDays()
    {
        return $this->workDays;
    }

    /**
     * Set workHours
     *
     * @param string $workHours
     *
     * @return UserEmployee
     */
    public function setWorkHours($workHours)
    {
        $this->workHours = $workHours;

        return $this;
    }

    /**
     * Get workHours
     *
     * @return string
     */
    public function getWorkHours()
    {
        return $this->workHours;
    }
}
