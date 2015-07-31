<?php

namespace HedgeComm\EmailBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use HedgeComm\EmailBundle\Entity\Client;
use HedgeComm\EmailBundle\Entity\SubscriberList;
use HedgeComm\EmailBundle\Form\ClientType;
use HedgeComm\EmailBundle\Form\SubscriberListType;

class ListController extends Controller
{
    /** 
     * Create a new list
     * 
     * @param HttpRequest $request
     * @param integer $clientid
     *
     */
    public function createSubscriberListAction(Request $request, $clientid) 
    {
		$subscriberList = new SubscriberList();
		$form = $this->createForm(new SubscriberListType($this->getDoctrine()->getManager()), $subscriberList)->add('save', 'submit');
		$client = $this->getDoctrine()->getRepository('HedgeCommEmailBundle:Client')->find($clientid);
		$form->handleRequest($request);
		/* Form is valid */
		if ($form->isValid()) 
		{
	        $values = array(
				'name' => $form->get('name')->getData(),
				'description' => $form->get('description')->getData(),
				'status' => $form->get('status')->getData(),
	        );
	        $subscriberList = new SubscriberList();
	        $subscriberList->setName($values['name']);
	        $subscriberList->setClient($client);
	        $subscriberList->setDescription($values['description']);
	        $subscriberList->setStatus($values['status']);
	        $subscriberList->setSecret(md5($values['name'] . microtime()));
	        $em = $this->getDoctrine()->getManager();
	        $em->persist($subscriberList);
	        $em->flush();
	
	        $this->addFlash('notice', 'A new subscriber list was saved');
	        return $this->redirectToRoute('client_detail', array('clientid' => $clientid));
		} else {
			/* Form is not (yet) valid */
			return $this->render('HedgeCommEmailBundle:List:create.html.twig', array('form' => $form->createView(), 'client' => $client));
		}
    }

	/**
	 * Edit an existing list
	 *
	 * @param HttpRequest $request
	 * @param integer $clientid
	 * @param integer $listid
	 *
	 */
    public function editSubscriberListAction(Request $request, $clientid, $listid) 
    {
		// check list and clientid
		$email_service = $this->get('email_service');
		$check = $email_service->checkList($clientid, $listid);
		if (!$check) {
			throw $this->createNotFoundException('No list found for client ' . $clientid . ' and list '. $listid);
		}
    
		$subscriberList = $this->getDoctrine()
			->getRepository('HedgeCommEmailBundle:SubscriberList')
			->find($listid);
		if (!$subscriberList) {
			throw $this->createNotFoundException('No list found for id ' . $listid);
		}
		$form = $this->createForm(new SubscriberListType($this->getDoctrine()->getManager()), $subscriberList)->add('save', 'submit');
		$client = $this->getDoctrine()->getRepository('HedgeCommEmailBundle:Client')->find($clientid);
		$form->handleRequest($request);
		if($form->isValid()) {
			$values = array(
				'name' => $form->get('name')->getData(),
				'description' => $form->get('description')->getData(),
				'status' => $form->get('status')->getData(),
			);      
			$em = $this->getDoctrine()->getManager();
			$subscriberList = $em->getRepository('HedgeCommEmailBundle:SubscriberList')->find($listid);
			if (!$subscriberList) {
				throw $this->createNotFoundException('No list found for id '.$listid);
			}
	        $subscriberList->setName($values['name']);
	        $subscriberList->setClient($client);
	        $subscriberList->setDescription($values['description']);
	        $subscriberList->setStatus($values['status']);
	        $em->flush();
	        $this->addFlash('notice', 'SubscriberList was updated');
	        return $this->redirectToRoute('client_detail', array('clientid' => $clientid));
		}
		return $this->render('HedgeCommEmailBundle:List:edit.html.twig', array('form' => $form->createView(), 'client' => $client));
    }
    
	/**
	 * Delete an existing list
	 *
	 * @param integer $clientid
	 * @param integer $listid
	 *
	 */
    public function deleteSubscriberListAction($clientid, $listid) 
    {
		// check list and clientid
		$email_service = $this->get('email_service');
		$check = $email_service->checkList($clientid, $listid);
		if (!$check) {
			throw $this->createNotFoundException('No list found for client ' . $clientid . ' and list '. $listid);
		}
		
		$em = $this->getDoctrine()->getManager();
		$subscriberList = $em->getRepository('HedgeCommEmailBundle:SubscriberList')->find($listid);
		if (!$subscriberList) {
			throw $this->createNotFoundException('No list found for id '.$listid);
		}
		$result = $em->getRepository('HedgeCommEmailBundle:SubscriberList')->deleteSubscriberLists($subscriberList);
		$this->addFlash('notice', 'List was deleted');
		return $this->redirectToRoute('client_detail', array('clientid' => $clientid));
    }

	/*
	 * Show detail of an existing list
	 *
	 * @param integer $clientid
	 * @param integer $listid
	 *
	 */
    public function detailSubscriberListAction($clientid, $listid) 
    {
		// check list and clientid
		$email_service = $this->get('email_service');
		$check = $email_service->checkList($clientid, $listid);
		if (!$check) {
			throw $this->createNotFoundException('No list found for client ' . $clientid . ' and list '. $listid);
		}
		$em = $this->getDoctrine()->getManager();
		$subscriberList = $em->getRepository('HedgeCommEmailBundle:SubscriberList')->find($listid);
		$client = $em->getRepository('HedgeCommEmailBundle:Client')->find($clientid);
		if (!$subscriberList) {
			throw $this->createNotFoundException('No list found for id '.$listid);
		}
		
		$subscribers = $em->getRepository('HedgeCommEmailBundle:Subscriber')->findBy(array('subscriberList' => $listid));
		return $this->render('HedgeCommEmailBundle:List:detail.html.twig', array(
			'client' => $client,
			'subscriberList' => $subscriberList,
			'subscribers' => $subscribers
			)
		);
    }
}
