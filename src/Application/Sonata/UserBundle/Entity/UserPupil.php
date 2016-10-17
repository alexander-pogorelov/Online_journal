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


}