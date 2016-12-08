<?php
/**
 * Created by PhpStorm.
 * User: Alex_PL
 * Date: 14.11.2016
 * Time: 17:39
 */

namespace Application\Sonata\UserBundle\Entity;


class Lesson
{
    private $id;

    private $topic; // тема урока

    private $homework; // домашнее задание

    private $teacherSubject;

    private $group;

    private $date;

    /**
     * Set topic
     *
     * @param string $topic
     *
     * @return Lesson
     */
    public function setTopic($topic)
    {
        $this->topic = $topic;

        return $this;
    }

    /**
     * Get topic
     *
     * @return string
     */
    public function getTopic()
    {
        return $this->topic;
    }

    /**
     * Set homework
     *
     * @param string $homework
     *
     * @return Lesson
     */
    public function setHomework($homework)
    {
        $this->homework = $homework;

        return $this;
    }

    /**
     * Get homework
     *
     * @return string
     */
    public function getHomework()
    {
        return $this->homework;
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
     * Set teacherSubject
     *
     * @param \Application\Sonata\UserBundle\Entity\TeacherSubject $teacherSubject
     *
     * @return Lesson
     */
    public function setTeacherSubject(\Application\Sonata\UserBundle\Entity\TeacherSubject $teacherSubject)
    {
        $this->teacherSubject = $teacherSubject;

        return $this;
    }

    /**
     * Get teacherSubject
     *
     * @return \Application\Sonata\UserBundle\Entity\TeacherSubject
     */
    public function getTeacherSubject()
    {
        return $this->teacherSubject;
    }

    /**
     * Set group
     *
     * @param \Application\Sonata\UserBundle\Entity\GroupIteen $group
     *
     * @return Lesson
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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Lesson
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
}
