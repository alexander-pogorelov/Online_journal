<?php
/**
 * Created by PhpStorm.
<<<<<<< HEAD
 * User: Ксения
 * Date: 17.10.2016
 * Time: 17:27
=======
 * User: Alex_PL
 * Date: 15.10.2016
 * Time: 21:15
>>>>>>> develop
 */

namespace Application\Sonata\UserBundle\Entity;


class UserTeacher extends UserEmployee
{
    private $subjects;


    public function __construct() {
        parent::__construct();
        $this->subjects = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add subject
     *
     * @param \Application\Sonata\UserBundle\Entity\Subject $subject
     *
     * @return UserTeacher
     */
    public function addSubject(\Application\Sonata\UserBundle\Entity\Subject $subject)
    {
        $this->subjects[] = $subject;

        return $this;
    }

    /**
     * Remove subject
     *
     * @param \Application\Sonata\UserBundle\Entity\Subject $subject
     */
    public function removeSubject(\Application\Sonata\UserBundle\Entity\Subject $subject)
    {
        $this->subjects->removeElement($subject);
    }

    /**
     * Get subjects
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSubjects()
    {
        return $this->subjects;
    }
}
