<?php
/**
 * Created by PhpStorm.
 * User: Alex_PL
 * Date: 27.10.2016
 * Time: 20:36
 */

namespace Application\Sonata\UserBundle\Entity;


class PupilGroupAssociation
{
    private $id;

    private $pupil;

    private $group;

    private $journal;

    /**
     * @return mixed
     */
    public function getJournal()
    {
        return $this->journal;
    }

    /**
     * @param mixed $journal
     */
    public function setJournal($journal)
    {
        $this->journal = $journal;
    }

    public function __construct(UserPupil $pupil, GroupIteen $group)
    {
        $this->pupil = $pupil;
        $this->group = $group;
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



}