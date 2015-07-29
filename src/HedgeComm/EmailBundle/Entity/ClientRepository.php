<?php

namespace HedgeComm\EmailBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ClientRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ClientRepository extends EntityRepository
{
	public function deleteClients($clients)
	{
		$em = $this->getEntityManager();
		
		if (!is_array($clients)) 
		{
			$clients = array($clients);
		}

		foreach ($clients as $client)
		{
		
			$clientId = $client->getId();
			$subscriberLists = $em->getRepository('HedgeCommEmailBundle:SubscriberList')->findBy(array('client' => $clientId));
			if (is_array($subscriberLists) && count($subscriberLists))
			{
				$result = $em->getRepository('HedgeCommEmailBundle:SubscriberList')->deleteSubscriberLists($subscriberLists);
			}
	
			$em->remove($client);
			$em->flush();
		}
	}
}