<?php
/**
 * Created by PhpStorm.
 * User: Alex_PL
 * Date: 27.10.2016
 * Time: 22:02
 */

namespace Application\Sonata\UserBundle\Entity;


use Doctrine\Common\Collections\ArrayCollection;

class GroupIteen
{
    public function __construct()
    {
        $this->pupilGroupAssociation = new ArrayCollection();
        $this->subjects = new ArrayCollection();
    }

    private $id;

    private $groupName;

    private $note;

    protected $pupilGroupAssociation;

    private $subjects;

    public function getPupils()
    {
        $pupilsArray = array_map(function (PupilGroupAssociation $pupilGroupAssociation) {
            return $pupilGroupAssociation->getPupil();
        }, $this->pupilGroupAssociation->toArray());

        return $pupilsArray;
    }

    public function getPupilsString()
    {
        return implode(', ', $this->getPupils());
    }
    public function getPupilsAmount()
    {
        return count($this->getPupils());
    }
    /**
     * @return ArrayCollection
     */
    public function getPupilGroupAssociation()
    {
        return $this->pupilGroupAssociation;
    }
    public function setPupilGroupAssociation(PupilGroupAssociation $pupilGroupAssociation)
    {
        $this->pupilGroupAssociation = $pupilGroupAssociation;
    }


    public function addPupilGroupAssociation(PupilGroupAssociation $pupilGroupAssociation)
    {
        $this->pupilGroupAssociation->add($pupilGroupAssociation);
        return $this;
    }

    public function removePupilGroupAssociation(PupilGroupAssociation $pupilGroupAssociation)
    {
        $this->pupilGroupAssociation->removeElement($pupilGroupAssociation);
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getGroupName()
    {
        return $this->groupName;
    }

    /**
     * @param mixed $groupName
     */
    public function setGroupName($groupName)
    {
        $this->groupName = $groupName;
    }

    /**
     * @return mixed
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @param mixed $note
     */
    public function setNote($note)
    {
        $this->note = $note;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getGroupName();
    }




    /**
     * Add subject
     *
     * @param \Application\Sonata\UserBundle\Entity\Subject $subject
     *
     * @return GroupIteen
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
