<?php
/**
 * Created by PhpStorm.
 * User: Igor Kachinskiy
 * Date: 31.10.2016
 * Time: 13:09
 */

namespace Application\Sonata\UserBundle\Entity;

use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * @ExclusionPolicy("all")
 */
class TeacherSubject
{
    private $id;

    private $teacher;

    /**
     * @Expose()
     */
    private $subject;

    public function __construct(UserTeacher $teacher, Subject $subject)
    {
        $this->subject = $subject;
        $this->teacher = $teacher;
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
     * Set teacher
     *
     * @param \Application\Sonata\UserBundle\Entity\UserTeacher $teacher
     *
     * @return TeacherSubject
     */
    public function setTeacher(UserTeacher $teacher)
    {
        $this->teacher = $teacher;

        return $this;
    }

    /**
     * Get teacher
     *
     * @return \Application\Sonata\UserBundle\Entity\UserTeacher
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
     * @return TeacherSubject
     */
    public function setSubject(Subject $subject)
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
}
