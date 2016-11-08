<?php
/**
 * Created by PhpStorm.
 * User: Igor Kachinskiy
 * Date: 08.11.2016
 * Time: 17:22
 */

namespace Application\Sonata\UserBundle\Entity;


use Doctrine\Common\Collections\ArrayCollection;

class Message
{
    protected $id;

    protected $topic;

    protected $message;

    protected $userMessage;

    public function __construct()
    {
        $this->userMessage = new ArrayCollection();
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $UserMessage;


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
        $this->UserMessage->add($userMessage);

        return $this;
    }

    /**
     * Remove userMessage
     *
     * @param \Application\Sonata\UserBundle\Entity\UserMessage $userMessage
     */
    public function removeUserMessage(UserMessage $userMessage)
    {
        $this->UserMessage->removeElement($userMessage);
    }

    /**
     * Get userMessage
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUserMessage()
    {
        return $this->UserMessage;
    }
}
