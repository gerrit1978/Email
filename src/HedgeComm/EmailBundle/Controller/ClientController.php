<?php

namespace HedgeComm\EmailBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use HedgeComm\EmailBundle\Entity\Client;
use HedgeComm\EmailBundle\Entity\SubscriberList;
use HedgeComm\EmailBundle\Form\ClientType;
use HedgeComm\EmailBundle\Form\SubscriberListType;

class ClientController extends Controller
{

	/**
	 * Show client overview
	 *
	 */
	public function clientOverviewAction() {
		$clients = $this->getDoctrine()->getRepository('HedgeCommEmailBundle:Client')->findAll();
		return $this->render('HedgeCommEmailBundle:Client:overview.html.twig', array('clients' => $clients));
	}
    
	/**
	 * Show client detail
	 *
	 * @param integer $clientid
	 *
	 */
	public function clientDetailAction($clientid) 
	{
		$client = $this->getDoctrine()->getRepository('HedgeCommEmailBundle:Client')->find($clientid);
		if (!$client) {
			throw $this->createNotFoundException('No client found for id ' . $clientid);
		}
		$subscriberLists = $this->getDoctrine()
								->getRepository('HedgeCommEmailBundle:SubscriberList')
								->findBy(
									array('client' => $clientid)
								);
		$campaigns = $this->getDoctrine()
							->getRepository('HedgeCommEmailBundle:Campaign')
							->findBy(
								array('client' => $clientid)
							);
		return $this->render('HedgeCommEmailBundle:Client:detail.html.twig', 
			array(
				'client' => $client, 
				'subscriberLists' => $subscriberLists,
				'campaigns' => $campaigns,
			)
		);
	}
    
	/**
	 * Create a new client
	 *
	 * @param HttpRequest $request
	 *
	 */
	public function clientCreateAction(Request $request)
	{
		$client = new Client();
		$form = $this->createForm(new ClientType(), $client)->add('save', 'submit');
		$form->handleRequest($request);
		/* Form is valid */
		if ($form->isValid())
		{
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
		} else
		{
			/* Form is not (yet) valid */
			return $this->render('HedgeCommEmailBundle:Client:create.html.twig', array('form' => $form->createView()));
		}
	}
    
	/**
	 * Edit an existing client
	 *
	 * @param HttpRequest $request
	 * @param integer $clientid
	 *
	 */
	public function clientEditAction(Request $request, $clientid)
	{
		$client = $this->getDoctrine()
						->getRepository('HedgeCommEmailBundle:Client')
						->find($clientid);
		if (!$client) {
			throw $this->createNotFoundException('No client found for id ' . $clientid);
		}
		$form = $this->createForm(new ClientType(), $client)->add('save', 'submit');
		$form->handleRequest($request);
		if($form->isValid()) {
			$values = array(
				'name' => $form->get('name')->getData(),
				'fromName' => $form->get('fromName')->getData(),
				'fromEmail' => $form->get('fromEmail')->getData(),
				'replyTo' => $form->get('replyTo')->getData(),
			);      
			$em = $this->getDoctrine()->getManager();
			$client = $em->getRepository('HedgeCommEmailBundle:Client')->find($clientid);
			if (!$client) {
				throw $this->createNotFoundException('No client found for id '.$clientid);
			}
			$client->setName($values['name']);
			$client->setFromName($values['fromName']);
			$client->setFromEmail($values['fromEmail']);
			$client->setReplyTo($values['replyTo']);
			$em->flush();
			$this->addFlash('notice', 'Client was updated');
			return $this->redirectToRoute('client_overview');
		}
		return $this->render('HedgeCommEmailBundle:Client:edit.html.twig', 
			array(
				'form' => $form->createView(), 
				'client' => $client
			)
		);
	}
	
	/**
	 * Delete an existing client
	 *
	 * @param integer $clientid
	 *
	 */
    public function clientDeleteAction($clientid)
    {
		$em = $this->getDoctrine()->getManager();
		$client = $em->getRepository('HedgeCommEmailBundle:Client')->find($clientid);
		if (!$client)
		{
			throw $this->createNotFoundException('No client found for id '.$clientid);
		}
		$result = $em->getRepository('HedgeCommEmailBundle:Client')->deleteClients($client);
		$this->addFlash('notice', 'Client was deleted');
		return $this->redirectToRoute('client_overview');
    }
    
	/**
	 * Generate the lists for this client
	 *
	 * @param integer $clientid
	 *
	 */
    public function clientListOverviewAction($clientid)
    {
		$em = $this->getDoctrine()->getManager();
		$lists = $em->getRepository('HedgeCommEmailBundle:SubscriberList')->findBy(array('client' => $clientid));
		$client = $em->getRepository('HedgeCommEmailBundle:Client')->find($clientid);
		if (!$client) {
			throw $this->createNotFoundException('No client found for id ' .$clientid);
		}
		return $this->render('HedgeCommEmailBundle:Client:lists.html.twig', 
			array(
				'lists' => $lists, 
				'client' => $client
			)
		);
    }
}