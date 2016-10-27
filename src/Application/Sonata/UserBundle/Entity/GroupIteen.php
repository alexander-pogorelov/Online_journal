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
        $this->pupilGroupAssociations = new ArrayCollection();
    }

    private $id;

    private $groupName;

    private $note;

    protected $pupilGroupAssociations;

    /**
     * @return ArrayCollection
     */
    public function getPupilGroupAssociations()
    {
        return $this->pupilGroupAssociations;
    }

    public function addPupilGroupAssociations(PupilGroupAssociations $pupilGroupAssociations)
    {
        $this->pupilGroupAssociations->add($pupilGroupAssociations);
        return $this;
    }

    public function removePupilGroupAssociations(PupilGroupAssociations $pupilGroupAssociations)
    {
        $this->pupilGroupAssociations->removeElement($pupilGroupAssociations);
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

}