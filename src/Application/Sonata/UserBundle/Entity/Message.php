<?php
/**
 * Created by PhpStorm.
 * User: Igor Kachinskiy
 * Date: 08.11.2016
 * Time: 17:22
 */

namespace Application\Sonata\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * @ExclusionPolicy("all")
 */
class Message
{
    /**
     * @Expose()
     */
    protected $id;

    /**
     * @Expose()
     */
    protected $topic;

    /**
     * @Expose()
     */
    protected $message;

    protected $userMessage;

    protected $messageGroup;

    /**
     * @Expose()
     */
    protected $sender;

    protected $groupIteen;

    protected $receiver;

    /**
     * @Expose()
     */
    protected $datetime;


    public static $messageGroupArray = [
        'все'=> 1,
        'методисты' => 2,
        'преподаватели'=> 3,
        'учащиеся' => 4,
    ];

    public function __construct()
    {
        $this->userMessage = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getMessageGroup()
    {
        return $this->messageGroup;
    }

    public function getMessageGroupString()
    {
        $array = explode(', ', $this->messageGroup);
        $result = [];
        foreach ($array as $key => $value){
            $result[] = array_search($value, self::$messageGroupArray);
        }
        return implode(', ', $result);
    }

    public function getReceivers()
    {
        $receiversArray = [$this->getReceiver(), $this->getMessageGroupString(), $this->getGroupIteen()];
        $receiversString = [];
        foreach ($receiversArray as $receiver){
            if(!empty($receiver)){
                $receiversString[] = $receiver;
            }
        }
        return implode(', ', $receiversString);
    }

    public function getReceiver()
    {
        return $this->receiver;
    }

    public function setReceiver($receiver)
    {
        $this->receiver = $receiver;

        return $this;
    }

    public function getDatetime()
    {
        return $this->datetime;
    }

    public function setDatetime($datetime)
    {
        $this->datetime = $datetime;

        return $this;
    }

    public function getSender()
    {
        return $this->sender;
    }

    public function setSender($sender)
    {
        $this->sender = $sender;

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

    public function getGroupIteen()
    {
        return $this->groupIteen;
    }

    public function setGroupIteen($groupIteen)
    {
        $this->groupIteen = $groupIteen;

        return $this;
    }
}
