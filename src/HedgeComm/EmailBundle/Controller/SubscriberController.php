<?php

namespace HedgeComm\EmailBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use HedgeComm\EmailBundle\Entity\Client;
use HedgeComm\EmailBundle\Entity\SubscriberList;
use HedgeComm\EmailBundle\Entity\Subscriber;
use HedgeComm\EmailBundle\Form\SubscriberType;

class SubscriberController extends Controller
{

	/**
	 * Add a single subscriber
	 *
	 * @param HttpRequest $request
	 * @param integer $clientid
	 * @param integer $listid
	 *
	 */
    public function subscriberAddSingleAction(Request $request, $clientid, $listid) 
    {
    	$em = $this->getDoctrine()->getManager();
	    // check list and clientid
		$email_service = $this->get('email_service');
		$check = $email_service->checkList($clientid, $listid);
		if (!$check) {
			throw $this->createNotFoundException('No list found for client ' . $clientid . ' and list '. $listid);
		}

		$client = $this->getDoctrine()->getRepository('HedgeCommEmailBundle:Client')->find($clientid);
		$subscriberList = $this->getDoctrine()->getRepository('HedgeCommEmailBundle:SubscriberList')->find($listid);
		
		$subscriber = new Subscriber();
		$form = $this->createForm(new SubscriberType($this->getDoctrine()->getManager()), $subscriber)->add('save', 'submit');
		$form->handleRequest($request);
		/* Form is valid */
		if ($form->isValid()) 
		{
	        $values = array(
				'name' => $form->get('name')->getData(),
				'email' => $form->get('email')->getData(),
	        );
	        $result = $em->getRepository('HedgeCommEmailBundle:Subscriber')->addSubscribers($values, $client, $subscriberList);
	        $this->addFlash('notice', 'A new subscriber was added');
	        return $this->redirectToRoute('subscriberlist_detail', array('clientid' => $clientid, 'listid' => $listid));
		} else {
			/* Form is not (yet) valid */
			return $this->render('HedgeCommEmailBundle:Subscriber:addsingle.html.twig', array('form' => $form->createView()));
		}		
    }
    
    /**
     * Add multiple subscribers using a text area
     *
     * @param HttpRequest $request
     * @param integer $clientid
     * @param integer $listid
     *
     */
    public function subscriberAddMultipleAction(Request $request, $clientid, $listid)
    {
    	$em = $this->getDoctrine()->getManager();
	    // check list and clientid
		$email_service = $this->get('email_service');
		$check = $email_service->checkList($clientid, $listid);
		if (!$check) {
			throw $this->createNotFoundException('No list found for client ' . $clientid . ' and list '. $listid);
		}

		$client = $this->getDoctrine()->getRepository('HedgeCommEmailBundle:Client')->find($clientid);
		$subscriberList = $this->getDoctrine()->getRepository('HedgeCommEmailBundle:SubscriberList')->find($listid);
    
	    $defaultData = array('message' => 'Type your message here');
	    $form = $this->createFormBuilder($defaultData)
	        ->add('subscribers', 'textarea')
	        ->add('save', 'submit')
	        ->getForm();
	
	    $form->handleRequest($request);
	
	    if ($form->isValid()) {
	        $data = $form->getData();
	        $values = trim($data['subscribers']);
	        $valuesModified = ereg_replace( "\n", "\n", $values);
	        $subscribers = explode("\n", $valuesModified);
	        $subscribersFinal = array();
	        if (count($subscribers)) 
	        {
		        foreach ($subscribers as $subscriber)
		        {
			        $subscriberArray = explode(',', $subscriber);
			        $name = $subscriberArray[0];
			        $email = $subscriberArray[1];
			        if (!$email) $email = "email";
			        $subscribersFinal[] = array('name' => $name, 'email' => $email);
		        }
	        }
	        $result = $em->getRepository('HedgeCommEmailBundle:Subscriber')->addSubscribers($subscribersFinal, $client, $subscriberList);
	        return $this->redirectToRoute('subscriberlist_detail', array('clientid' => $clientid, 'listid' => $listid));
	        
	    }
	    
	    return $this->render('HedgeCommEmailBundle:Subscriber:addmultiple.html.twig', array('form' => $form->createView()));
    }
    
    /**
     * Import a CSV file with subscribers
     *
     * @param HttpRequest $request
     * @param integer $clientid
     * @param integer $listid
     *
     */
    public function subscriberimportCsvAction(Request $request, $clientid, $listid)
    {
    	$em = $this->getDoctrine()->getManager();
	    // check list and clientid
		$email_service = $this->get('email_service');
		$check = $email_service->checkList($clientid, $listid);
		if (!$check) {
			throw $this->createNotFoundException('No list found for client ' . $clientid . ' and list '. $listid);
		}

		$client = $this->getDoctrine()->getRepository('HedgeCommEmailBundle:Client')->find($clientid);
		$subscriberList = $this->getDoctrine()->getRepository('HedgeCommEmailBundle:SubscriberList')->find($listid);
    
	    $defaultData = array('message' => 'Type your message here');
	    $form = $this->createFormBuilder()
        	->add('submitFile', 'file', array('label' => 'File to Submit'))
	        ->add('save', 'submit')
        	->getForm();
	    $form->handleRequest($request);
	
	    if ($form->isValid()) {
			// Get file
			$file = $form->get('submitFile')->getData();
			
			// Your csv file here when you hit submit button
			$values = file_get_contents($file->getPathname());
			$values = str_replace(';', ',', $values);
	        $valuesModified = ereg_replace( "\n", "\n", $values);
	        $subscribers = explode("\n", $valuesModified);
	        $subscribersFinal = array();
	        if (count($subscribers)) 
	        {
		        foreach ($subscribers as $subscriber)
		        {
			        $subscriberArray = explode(',', $subscriber);
			        $name = $subscriberArray[0];
			        $email = $subscriberArray[1];
			        if (!$email) $email = "email";
			        $subscribersFinal[] = array('name' => $name, 'email' => $email);
		        }
	        }
	        $result = $em->getRepository('HedgeCommEmailBundle:Subscriber')->addSubscribers($subscribersFinal, $client, $subscriberList);
	        return $this->redirectToRoute('subscriberlist_detail', array('clientid' => $clientid, 'listid' => $listid));
/*
	        $data = $form->getData();
	        $values = trim($data['subscribers']);
	        $valuesModified = ereg_replace( "\n", "\n", $values);
	        $subscribers = explode("\n", $valuesModified);
	        $subscribersFinal = array();
	        if (count($subscribers)) 
	        {
		        foreach ($subscribers as $subscriber)
		        {
			        $subscriberArray = explode(',', $subscriber);
			        $name = $subscriberArray[0];
			        $email = $subscriberArray[1];
			        if (!$email) $email = "email";
			        $subscribersFinal[] = array('name' => $name, 'email' => $email);
		        }
	        }
	        $result = $em->getRepository('HedgeCommEmailBundle:Subscriber')->addSubscribers($subscribersFinal, $client, $subscriberList);
*/	        
	        return $this->redirectToRoute('subscriberlist_detail', array('clientid' => $clientid, 'listid' => $listid));
	        
	    }
	    
	    return $this->render('HedgeCommEmailBundle:Subscriber:addmultiple.html.twig', array('form' => $form->createView()));
    }
}
