<?php

namespace Application\Sonata\UserBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * Schedule
 * @UniqueEntity(
 *     fields={"weekday", "group", "teacher", "timeinterval", "classroom"},
 *     errorPath="port",
 *     message="Такой элемент уже существует в расписании!"
 * )
 * @UniqueEntity(
 *     fields={"weekday", "group", "timeinterval"},
 *     errorPath="group",
 *     message="Группа в это время занята!"
 * )
 * @UniqueEntity(
 *     fields={"weekday", "timeinterval", "classroom"},
 *     errorPath="classroom",
 *     message="Аудитория занята!"
 * )
 * @UniqueEntity(
 *     fields={"weekday", "timeinterval", "teacher"},
 *     errorPath="teacher",
 *     message="Преподователь занят!"
 * )
 * @ExclusionPolicy("all")
 */
class Schedule
{
    /**
     * @var integer
     *
     * @Assert\NotBlank(message="Заполните поле")
     * @Expose()
     */
    private $weekday;

    private $titleweekday = '';

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Application\Sonata\UserBundle\Entity\GroupIteen
     *
     * @Assert\NotBlank(message="Заполните поле")
     * @Expose()
     */
    private $group;

    /**
     * @var \Application\Sonata\UserBundle\Entity\User
     *
     * @Assert\NotBlank(message="Заполните поле")
     * @Expose()
     */
    private $teacher;

    /**
     * @var \Application\Sonata\UserBundle\Entity\Subject
     *
     * @Assert\NotBlank(message="Заполните поле")
     * @Expose()
     */
    private $subject;

    /**
     * @var \Application\Sonata\UserBundle\Entity\TimeInterval
     *
     * @Assert\NotBlank(message="Заполните поле")
     * @Expose()
     */
    private $timeinterval;

    /**
     * @var \Application\Sonata\UserBundle\Entity\Classroom
     *
     * @Assert\NotBlank(message="Заполните поле")
     * @Expose()
     */
    private $classroom;


    /**
     * Set weekday
     *
     * @param integer $weekday
     *
     * @return Schedule
     */
    public function setWeekday($weekday)
    {
        $this->weekday = $weekday;

        return $this;
    }

    /**
     * Get weekday
     *
     * @return integer
     */
    public function getWeekday()
    {
        return $this->weekday;
    }

    public function getWeekdays()
    {
        $weekdays = [
            '1' => ['short' => 'ПН', 'full' => 'Понедельник'],
            '2' => ['short' => 'ВТ', 'full' => 'Вторник'],
            '3' => ['short' => 'СР', 'full' => 'Среда'],
            '4' => ['short' => 'ЧТ', 'full' => 'Четверг'],
            '5' => ['short' => 'ПТ', 'full' => 'Пятница'],
            '6' => ['short' => 'СБ', 'full' => 'Суббота'],
            '0' => ['short' => 'ВС', 'full' => 'Воскресенье'],
        ];
        return $weekdays;
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
     * Set group
     *
     * @param \Application\Sonata\UserBundle\Entity\GroupIteen $group
     *
     * @return Schedule
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
     * Set teacher
     *
     * @param \Application\Sonata\UserBundle\Entity\UserTeacher $teacher
     *
     * @return Schedule
     */
    public function setTeacher(\Application\Sonata\UserBundle\Entity\UserTeacher $teacher = null)
    {
        $this->teacher = $teacher;

        return $this;
    }

    /**
     * Get teacher
     *
     * @return \Application\Sonata\UserBundle\Entity\User
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
     * @return Schedule
     */
    public function setSubject(\Application\Sonata\UserBundle\Entity\Subject $subject = null)
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

    /**
     * Set timeinterval
     *
     * @param \Application\Sonata\UserBundle\Entity\TimeInterval $timeinterval
     *
     * @return Schedule
     */
    public function setTimeinterval(\Application\Sonata\UserBundle\Entity\TimeInterval $timeinterval = null)
    {
        $this->timeinterval = $timeinterval;

        return $this;
    }

    /**
     * Get timeinterval
     *
     * @return \Application\Sonata\UserBundle\Entity\TimeInterval
     */
    public function getTimeinterval()
    {
        return $this->timeinterval;
    }

    /**
     * Set classroom
     *
     * @param \Application\Sonata\UserBundle\Entity\Classroom $classroom
     *
     * @return Schedule
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

    /**
     * @return mixed
     */
    public function getTitleWeekday()
    {
        if ($this->getId()){
            return self::getWeekdays()[$this->weekday]['full'];
        }

        return '';
    }
}

