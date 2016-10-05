<?php
/**
 * Created by PhpStorm.
 * User: Alex_PL
 * Date: 01.10.2016
 * Time: 20:12
 */

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;


use Sonata\UserBundle\Entity\BaseUser;


/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user_user")
 */
class Iuser extends BaseUser
{
    /**
     * @var int $id
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Get id
     *
     * @return int $id
     */
    public function getId()
    {
        return $this->id;
    }
}