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
			exit('campaign ingevoerd');
/*
			$values = array(
				'name' => $form->get('name')->getData(),
				'fromName' => $form->get('fromName')->getData(),
				'fromEmail' => $form->get('fromEmail')->getData(),
				'replyTo' => $form->get('replyTo')->getData(),
			);
			$client = new Client();
			$client->setName($values['name']);
			$client->setFromName($values['fromName']);
			$client->setFromEmail($values['fromEmail']);
			$client->setReplyTo($values['replyTo']);
			$client->setSecret(md5($values['name'] . microtime()));
			$em = $this->getDoctrine()->getManager();
			$em->persist($client);
			$em->flush();
			
			$this->addFlash('notice', 'A new client was saved');
			return $this->redirectToRoute('client_overview');
*/
		} else
		{
			/* Form is not (yet) valid */
			return $this->render('HedgeCommEmailBundle:Campaign:create.html.twig', array('form' => $form->createView(), 'client' => $client));
		}
	}
    
}