<?php

namespace HedgeComm\EmailBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * SubscriberListRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SubscriberListRepository extends EntityRepository
{

	public function deleteSubscriberLists($subscriberLists)
	{
		$em = $this->getEntityManager();
	
		if (!is_array($subscriberLists)) 
		{
			$subscriberLists = array($subscriberLists);
		}
	
		foreach ($subscriberLists as $subscriberList)
		{
			$subscriberListId = $subscriberList->getId();
			$subscribers = $em->getRepository('HedgeCommEmailBundle:Subscriber')->findBy(
				array(
					'subscriberList' => $subscriberListId
				)
			);
			if (is_array($subscribers) && count($subscribers))
			{
				$result = $em->getRepository('HedgeCommEmailBundle:Subscriber')->deleteSubscribers($subscribers);
			}
			$em->remove($subscriberList);
			$em->flush();
		}
	}

}