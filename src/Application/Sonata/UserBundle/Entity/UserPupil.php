<?php
/**
 * Created by PhpStorm.
 * User: Alex_PL
 * Date: 15.10.2016
 * Time: 21:14
 */

namespace Application\Sonata\UserBundle\Entity;


class UserPupil extends User
{
    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $parents;


    //protected $id;

    public function __construct()
    {
        parent::__construct();
        $this->parents = new \Doctrine\Common\Collections\ArrayCollection();
    }
    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getParents()
    {
        return $this->parents;
    }
    public function getParentsPhones()
    {
        $parentsPhones = array_map(function (UserParent $parent) {
            return $parent->getPhone();
        }, $this->getParents()->toArray());

        return implode(', ', $parentsPhones);
    }
    public function getParentsEmailes()
    {
        $parentsEmailes = array_map(function (UserParent $parent) {
            return $parent->getEmailCanonical();
        }, $this->getParents()->toArray());

        return implode(', ', $parentsEmailes);
    }

}