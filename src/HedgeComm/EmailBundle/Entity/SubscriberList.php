<?php

namespace HedgeComm\EmailBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * SubscriberList
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="HedgeComm\EmailBundle\Entity\SubscriberListRepository")
 */
class SubscriberList
{
	 /**
     * @ORM\ManyToOne(targetEntity="Client")
     * @ORM\JoinColumn(name="clientId")
     */
    protected $client;
    	
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
	 * @var text
	 *
	 * @ORM\Column(name="description", type="text", nullable=true)
	 */
	private $description;

    /**
	 * @var boolean
	 *
	 * @ORM\Column(name="status", type="boolean")
	 */
	private $status;

	/**
	 * @var secret
	 * 
	 * @ORM\Column(name="secret", type="string", length=48)
	 */
	private $secret;

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
     * Set name
     *
     * @param string $name
     * @return SubscriberList
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
	 * Set description
	 *
	 * @param string $description
	 * @return SubscriberList
	 */
	public function setDescription($description)
	{
		$this->description = $description;
		
		return $this;
	}
	
	/**
	 * Get description
	 *
	 * @return string
	 *
	 */
	public function getDescription()
	{
		return $this->description;
	}
	
	/**
     * Set status
     *
     * @param int $status
     * @return SubscriberList
     */
    public function setStatus($status)
    {
	    $this->status = $status;
    }
    
    /**
	 * Get status
	 *
	 * @return int
	 *
	 */
	public function getStatus() 
	{
		return $this->status;
	}
	
    /**
	 * Set secret
	 *
	 * @param string $secret
	 * @return SubscriberList
	 */
	public function setSecret($secret)
	{
		$this->secret = $secret;
		
		return $this;
	}
	
	/**
	 * Get secret
	 *
	 * @return string
	 *
	 */
	public function getSecret()
	{
		return $this->secret;
	}

}
