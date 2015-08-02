<?php

namespace HedgeComm\EmailBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Campaign
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="HedgeComm\EmailBundle\Entity\CampaignRepository")
 */
class Campaign
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
     * @ORM\Column(name="fromName", type="string", length=255)
     */
    private $fromName;

    /**
     * @var string
     *
     * @ORM\Column(name="fromEmail", type="string", length=255)
     */
    private $fromEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="replyTo", type="string", length=255)
     */
    private $replyTo;

    /**
     * @var string
     *
     * @ORM\Column(name="textPlain", type="text")
     */
    private $textPlain;

    /**
     * @var string
     *
     * @ORM\Column(name="textHtml", type="text")
     */
    private $textHtml;

    /**
     * @var boolean
     *
     * @ORM\Column(name="sent", type="boolean")
     */
    private $sent;

    /**
	 * Set client
	 * 
	 * @param HedgeCommEmailBundle:Client $client
	 * @return Campaign
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set fromName
     *
     * @param string $fromName
     * @return Campaign
     */
    public function setFromName($fromName)
    {
        $this->fromName = $fromName;

        return $this;
    }

    /**
     * Get fromName
     *
     * @return string 
     */
    public function getFromName()
    {
        return $this->fromName;
    }

    /**
     * Set fromEmail
     *
     * @param string $fromEmail
     * @return Campaign
     */
    public function setFromEmail($fromEmail)
    {
        $this->fromEmail = $fromEmail;

        return $this;
    }

    /**
     * Get fromEmail
     *
     * @return string 
     */
    public function getFromEmail()
    {
        return $this->fromEmail;
    }

    /**
     * Set replyTo
     *
     * @param string $replyTo
     * @return Campaign
     */
    public function setReplyTo($replyTo)
    {
        $this->replyTo = $replyTo;

        return $this;
    }

    /**
     * Get replyTo
     *
     * @return string 
     */
    public function getReplyTo()
    {
        return $this->replyTo;
    }

    /**
     * Set textPlain
     *
     * @param string $textPlain
     * @return Campaign
     */
    public function setTextPlain($textPlain)
    {
        $this->textPlain = $textPlain;

        return $this;
    }

    /**
     * Get textPlain
     *
     * @return string 
     */
    public function getTextPlain()
    {
        return $this->textPlain;
    }

    /**
     * Set textHtml
     *
     * @param string $textHtml
     * @return Campaign
     */
    public function setTextHtml($textHtml)
    {
        $this->textHtml = $textHtml;

        return $this;
    }

    /**
     * Get textHtml
     *
     * @return string 
     */
    public function getTextHtml()
    {
        return $this->textHtml;
    }

    /**
     * Set sent
     *
     * @param boolean $sent
     * @return Campaign
     */
    public function setSent($sent)
    {
        $this->sent = $sent;

        return $this;
    }

    /**
     * Get sent
     *
     * @return boolean 
     */
    public function getSent()
    {
        return $this->sent;
    }
    
    /**
     * Set recipients
     *
     * @param string $recipients
     * @return Campaign
     */
    public function setRecipients($recipients)
    {
	    $this->recipients = $recipients;
	    
	    return $this;
    }
    
    /**
     * Get recipients
     *
     * @return string
     */
    public function getRecipients()
    {
	    return $this->recipients;
    }
}
