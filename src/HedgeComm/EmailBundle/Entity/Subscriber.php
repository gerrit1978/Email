<?php

namespace HedgeComm\EmailBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Subscriber
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="HedgeComm\EmailBundle\Entity\SubscriberRepository")
 */
class Subscriber
{

	 /**
     * @ORM\ManyToOne(targetEntity="Client")
     * @ORM\JoinColumn(name="clientId")
     */
    protected $client;

	 /**
     * @ORM\ManyToOne(targetEntity="SubscriberList")
     * @ORM\JoinColumn(name="subscriberlistId")
     */
    protected $subscriberList;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var boolean
     *
     * @ORM\Column(name="unsubscribed", type="boolean")
     */
    private $unsubscribed;

    /**
     * @var integer
     *
     * @ORM\Column(name="timestamp", type="integer")
     */
    private $timestamp;

    /**
	 * Set client
	 * 
	 * @param HedgeCommEmailBundle:Client $client
	 * @return SubscriberList
	 */
	public function setClient($client)
	{
		$this->client = $client;
		return $this;
	}
	
	/**
     * Get client
     *
     * @return HedgeCommEmailBundle:Client
     */
    public function getClient() 
    {
	    return $this->client;
    }

    /**
	 * Set subscriberList
	 * 
	 * @param HedgeCommEmailBundle:SubscriberList $subscriberList
	 * @return SubscriberList
	 */
	public function setSubscriberList($subscriberList)
	{
		$this->subscriberList = $subscriberList;
		return $this;
	}
	
	/**
     * Get subscriberList
     *
     * @return HedgeCommEmailBundle:SubscriberList
     */
    public function getSubscriberList() 
    {
	    return $this->subscriberList;
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
     * Set name
     *
     * @param string $name
     * @return Subscriber
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Subscriber
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set unsubscribed
     *
     * @param boolean $unsubscribed
     * @return Subscriber
     */
    public function setUnsubscribed($unsubscribed)
    {
        $this->unsubscribed = $unsubscribed;

        return $this;
    }

    /**
     * Get unsubscribed
     *
     * @return boolean 
     */
    public function getUnsubscribed()
    {
        return $this->unsubscribed;
    }

    /**
     * Set timestamp
     *
     * @param integer $timestamp
     * @return Subscriber
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    /**
     * Get timestamp
     *
     * @return integer 
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }
}
