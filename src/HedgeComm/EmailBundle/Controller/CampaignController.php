<?php

namespace HedgeComm\EmailBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use HedgeComm\EmailBundle\Entity\Client;
use HedgeComm\EmailBundle\Entity\SubscriberList;
use HedgeComm\EmailBundle\Entity\Campaign;
use HedgeComm\EmailBundle\Form\ClientType;
use HedgeComm\EmailBundle\Form\SubscriberListType;
use HedgeComm\EmailBundle\Form\CampaignType;

class CampaignController extends Controller
{

	/**
	 * Create a new campaign
	 *
	 * @param HttpRequest $request
	 *
	 */
	public function campaignCreateAction(Request $request, $clientid)
	{
	
		$client = $this->getDoctrine()->getRepository('HedgeCommEmailBundle:Client')->find($clientid);	
		$campaign = new Campaign();
		$form = $this->createForm(new CampaignType(), $campaign)->add('save', 'submit');
		$form->handleRequest($request);		
		/* Form is valid */
		if ($form->isValid())
		{
			$values = array(
				'name' => $form->get('name')->getData(),
				'fromName' => $form->get('fromName')->getData(),
				'fromEmail' => $form->get('fromEmail')->getData(),
				'replyTo' => $form->get('replyTo')->getData(),
				'textPlain' => $form->get('textPlain')->getData(),
				'textHtml' => $form->get('textHtml')->getData(),
			);
			
			$campaign = new Campaign();
			$campaign->setName($values['name']);
			$campaign->setFromName($values['fromName']);
			$campaign->setFromEmail($values['fromEmail']);
			$campaign->setReplyTo($values['replyTo']);
			$campaign->setTextPlain($values['textPlain']);
			$campaign->setTextHtml($values['textHtml']);
			$campaign->setSent(0);
			$campaign->setClient($client);
			$em = $this->getDoctrine()->getManager();
			$em->persist($campaign);
			$em->flush();
			
			$this->addFlash('notice', 'A new campaign was saved');
			return $this->redirectToRoute('client_detail', array('clientid' => $clientid));

		} else
		{
			/* Form is not (yet) valid */
			return $this->render('HedgeCommEmailBundle:Campaign:create.html.twig', array('form' => $form->createView(), 'client' => $client));
		}
	}
    
}