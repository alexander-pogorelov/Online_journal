<?php
/**
 * Created by PhpStorm.
 * User: Alex_PL
 * Date: 12.11.2016
 * Time: 13:49
 */

namespace Application\Sonata\UserBundle\Entity;


class Journal
{
    private $id;

    private $lesson;

    private $pupilGroup;

    private $assessment; // оценка по предмету (если "-1", то отсутствует на уроке)

    private $remark; // комментарий к оценке



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
     * Set remark
     *
     * @param string $remark
     *
     * @return Journal
     */
    public function setRemark($remark)
    {
        $this->remark = $remark;

        return $this;
    }

    /**
     * Get remark
     *
     * @return string
     */
    public function getRemark()
    {
        return $this->remark;
    }

    /**
     * Set assessment
     *
     * @param integer $assessment
     *
     * @return Journal
     */
    public function setAssessment($assessment)
    {
        $this->assessment = $assessment;

        return $this;
    }

    /**
     * Get assessment
     *
     * @return integer
     */
    public function getAssessment()
    {
        return $this->assessment;
    }

    /**
     * Set pupilGroup
     *
     * @param \Application\Sonata\UserBundle\Entity\PupilGroupAssociation $pupilGroup
     *
     * @return Journal
     */
    public function setPupilGroup(\Application\Sonata\UserBundle\Entity\PupilGroupAssociation $pupilGroup = null)
    {
        $this->pupilGroup = $pupilGroup;

        return $this;
    }

    /**
     * Get pupilGroup
     *
     * @return \Application\Sonata\UserBundle\Entity\PupilGroupAssociation
     */
    public function getPupilGroup()
    {
        return $this->pupilGroup;
    }

    /**
     * Set lesson
     *
     * @param \Application\Sonata\UserBundle\Entity\Lesson $lesson
     *
     * @return Journal
     */
    public function setLesson(\Application\Sonata\UserBundle\Entity\Lesson $lesson)
    {
        $this->lesson = $lesson;

        return $this;
    }

    /**
     * Get lesson
     *
     * @return \Application\Sonata\UserBundle\Entity\Lesson
     */
    public function getLesson()
    {
        return $this->lesson;
    }
    /**
     * @var boolean
     */
    private $isAbsent;


    /**
     * Set isAbsent
     *
     * @param boolean $isAbsent
     *
     * @return Journal
     */
    public function setIsAbsent($isAbsent)
    {
        $this->isAbsent = $isAbsent;

        return $this;
    }

    /**
     * Get isAbsent
     *
     * @return boolean
     */
    public function getIsAbsent()
    {
        return $this->isAbsent;
    }
}
