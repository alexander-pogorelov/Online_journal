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
    public function __construct()
    {
        parent::__construct();
        $this->parents = new \Doctrine\Common\Collections\ArrayCollection();
    }
    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $parents;
    /**
     * @var
     */
    private $classNumber;
    /**
     * @return mixed
     */
    public function getClassNumber()
    {
        return $this->classNumber;
    }
    public function getClassNumberString()
    {
        return $this->classNumber ? $this->classNumber.'-й класс' : '';
    }
    /**
     * @param mixed $classNumber
     */
    public function setClassNumber($classNumber)
    {
        $this->classNumber = $classNumber;
    }

    public function addParent($parent)
    {
        $this->parents->add($parent);
    }

    public function removeParent($parent)
    {
        $this->parents->removeElement($parent);
    }

    public function setParents($parents)
    {
        $this->parents = $parents;
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

        //return implode(', ', $parentsPhones);
        return $this->arrayToString($parentsPhones);
    }
    public function getParentsEmailes()
    {
        $parentsEmailes = array_map(function (UserParent $parent) {
            return $parent->getEmailCanonical();
        }, $this->getParents()->toArray());

        return implode(', ', $parentsEmailes);
    }
    public function getParentsRelationships()
    {
        $parentsRelationships = array_map(function (UserParent $parent) {
            return $parent->getRelationshipString();
        }, $this->getParents()->toArray());

        //return implode(', ', $parentsRelationships);
        return $this->arrayToString($parentsRelationships);
    }
    private function arrayToString($inputArray)
    {   $arrayToString = '';
        foreach ($inputArray as $item)
        {
            if($item) {
                $arrayToString = $arrayToString.', '.$item;
            }else {
                $arrayToString = $arrayToString.', нет данных';
            }
        }
        return ltrim($arrayToString, ', ');
    }

}
