<?php

/**
 * This file is part of the <name> project.
 *
 * (c) <yourname> <youremail>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Sonata\UserBundle\Entity;

use Sonata\UserBundle\Entity\BaseUser as BaseUser;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * This file has been generated by the Sonata EasyExtends bundle.
 *
 * @link https://sonata-project.org/bundles/easy-extends
 *
 * References :
 *   working with object : http://www.doctrine-project.org/projects/orm/2.0/docs/reference/working-with-objects/en
 *
 * @author <yourname> <youremail>
 */

/**
 *@UniqueEntity(
 *     "email",
 * message="Пользователь с таким адресом электронной почты уже существует."
 * )
 */
abstract class User extends BaseUser
{

    protected $patronymic;

    /**
     * @var
     */
    protected $comment;

    protected $address;

    protected $userMessage;

    public function __construct()
    {
        parent::__construct();
        $this->userMessage = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param mixed $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }
    /**
     * @return mixed
     */
    public function getPatronymic()
    {
        return $this->patronymic;
    }

    /**
     * @param mixed $patronymic
     */
    public function setPatronymic($patronymic)
    {
        $this->patronymic = $patronymic;
    }

    public function getId()
    {
        return $this->id;
    }

    public function __toString()
    {
        $string = $this->getLastname().' '.$this->getFirstname().' '.$this->getPatronymic();
        if (!$string) {
            $string = $this->getUsername();
        }

        return $string;
    }
    /**
     * Set address
     *
     * @param string $address
     *
     * @return User
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }


    public function getFullName()
    {
        return $this->getLastname().' '.$this->getFirstname().' '.$this->getPatronymic() ;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */

    /**
     * Add userMessage
     *
     * @param \Application\Sonata\UserBundle\Entity\UserMessage $userMessage
     *
     * @return User
     */
    public function addUserMessage(UserMessage $userMessage)
    {
        $this->userMessage->add($userMessage);

        return $this;
    }

    /**
     * Remove userMessage
     *
     * @param \Application\Sonata\UserBundle\Entity\UserMessage $userMessage
     */
    public function removeUserMessage(UserMessage $userMessage)
    {
        $this->userMessage->removeElement($userMessage);
    }

    /**
     * Get userMessage
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUserMessage()
    {
        return $this->userMessage;
    }
}
