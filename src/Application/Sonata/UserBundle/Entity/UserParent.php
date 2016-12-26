<?php
/**
 * Created by PhpStorm.
 * User: Alex_PL
 * Date: 16.10.2016
 * Time: 10:13
 */

namespace Application\Sonata\UserBundle\Entity;

use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * @ExclusionPolicy("all")
 */
class UserParent extends User
{
    private $relationship;
    public static $relationshipArray = [
        'мать'=> 1,
        'отец'=> 2,
        'бабушка'=> 3,
        'дедушка' => 4,
        'другое' => 5
    ];


    /**
     * @return mixed
     */
    public function getRelationship()
    {
        return $this->relationship;
    }
    public function getRelationshipString()
    {
        return array_search($this->relationship , self::$relationshipArray, true);
    }

    /**
     * @param mixed $relationship
     */
    public function setRelationship($relationship)
    {
        $this->relationship = $relationship;
    }
}
