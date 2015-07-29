<?php

namespace HedgeComm\EmailBundle\Services;
use Doctrine\ORM\EntityManager;
use HedgeComm\EmailBundle\Entity\SubscriberList;

class EmailService {

	protected $em;

	public function __construct(EntityManager $entityManager)
	{
	    $this->em = $entityManager;
	}

	public function checkList($clientid, $listid) 
	{
	    $query = $this->em->createQuery(
	    	'SELECT l
	    	FROM HedgeCommEmailBundle:SubscriberList l
	    	WHERE l.client = :clientid AND l.id = :listid'
	    )->setParameters(
	    	array(
	    		'clientid' => $clientid,
	    		'listid' => $listid
	    	)
	    );

	    $lists = $query->getResult();
	    if (count($lists) <= 0)
	    {
		    return FALSE;
	    } else
	    {
		    return TRUE;
	    }
	} 
}