<?php
/**
 * Created by PhpStorm.
 * User: Alexander Pogorelov
 * Date: 27.10.2016
 * Time: 20:36
 */

namespace Application\Sonata\UserBundle\Entity;


use Doctrine\Common\Collections\ArrayCollection;

class PupilGroupAssociation
{
    private $id;

    private $pupil;

    private $group;

    private $journal;

    public function __construct(UserPupil $pupil, GroupIteen $group)
    {
        $this->pupil = $pupil;
        $this->group = $group;
        $this->journal = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    public function setPupil(UserPupil $pupil = null)
    {
        $this->pupil = $pupil;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPupil()
    {
        return $this->pupil;
    }

    public function setGroup(GroupIteen $group = null)
    {
        $this->group = $group;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * Add journal
     *
     * @param \Application\Sonata\UserBundle\Entity\Journal $journal
     *
     * @return PupilGroupAssociation
     */
    public function addJournal(\Application\Sonata\UserBundle\Entity\Journal $journal)
    {
        $this->journal[] = $journal;

        return $this;
    }

    /**
     * Remove journal
     *
     * @param \Application\Sonata\UserBundle\Entity\Journal $journal
     */
    public function removeJournal(\Application\Sonata\UserBundle\Entity\Journal $journal)
    {
        $this->journal->removeElement($journal);
    }


    /**
     * Get journal
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getJournal()
    {
        return $this->journal;
    }

}
