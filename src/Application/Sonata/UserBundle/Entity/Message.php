<?php
/**
 * Created by PhpStorm.
 * User: Igor Kachinskiy
 * Date: 08.11.2016
 * Time: 17:22
 */

namespace Application\Sonata\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;


class Message
{
    protected $id;

    protected $topic;

    protected $message;

    protected $userMessage;

    protected $messageGroup;

    protected $receiver;


    public static $messageGroupArray = [
        'все'=> 0,
        'методисты'=> 4,
        'преподаватели'=> 2,
        'учащиеся' => 1,
    ];


    /**
     * @return mixed
     */
    public function getMessageGroup()
    {
        return $this->messageGroup;
    }
    public function getMessageGroupString()
    {
        return array_search($this->messageGroup , self::$messageGroupArray, true);
    }

    public function __construct()
    {
        $this->userMessage = new ArrayCollection();
    }

    public function getReceivers()
    {
        return implode(' ', [
            $this->getUsers(),
            $this->getMessageGroupString()
        ]
        );
    }

    public function setReceivers($receiver)
    {
        $this->receiver = $receiver;

        return $this;
    }

    /**
     * Set topic
     *
     * @param string $topic
     *
     * @return Message
     */
    public function setTopic($topic)
    {
        $this->topic = $topic;

        return $this;
    }

    /**
     * Get topic
     *
     * @return string
     */
    public function getTopic()
    {
        return $this->topic;
    }

    /**
     * Set message
     *
     * @param string $message
     *
     * @return Message
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Add userMessage
     *
     * @param \Application\Sonata\UserBundle\Entity\UserMessage $userMessage
     *
     * @return Message
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

    public function getUsers()
    {
        $usersArray = array_map(function (UserMessage $userMessage) {
            return $userMessage->getUser();
        }, $this->userMessage->toArray());

        return implode(', ', $usersArray);
    }

    /**
     * Set messageGroup
     *
     * @param integer $messageGroup
     *
     * @return Message
     */
    public function setMessageGroup($messageGroup)
    {
        $this->messageGroup = $messageGroup;

        return $this;
    }
}
