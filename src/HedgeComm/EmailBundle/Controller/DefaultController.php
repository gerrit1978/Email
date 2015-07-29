<?php

namespace HedgeComm\EmailBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use HedgeComm\EmailBundle\Entity\Client;
use HedgeComm\EmailBundle\Entity\SubscriberList;
use HedgeComm\EmailBundle\Form\ClientType;
use HedgeComm\EmailBundle\Form\SubscriberListType;

class DefaultController extends Controller
{

    public function homeAction() {
      return $this->redirectToRoute('client_overview');
    }

    /* DUMMY HOMEPAGE */
    public function indexAction($name)
    {
        return $this->render('HedgeCommEmailBundle:Default:index.html.twig', array('name' => $name));
    }
    
    /* CLIENT OVERVIEW */
    public function clientOverviewAction() {
      $clients = $this->getDoctrine()->getRepository('HedgeCommEmailBundle:Client')->findAll();
      return $this->render('HedgeCommEmailBundle:Client:overview.html.twig', array('clients' => $clients));
    }
    
    /* CLIENT CREATE */
    public function createClientAction(Request $request) {
    
      $client = new Client();
      $form = $this->createForm(new ClientType(), $client)->add('save', 'submit');
      $form->handleRequest($request);
      /* Form is valid */
      if ($form->isValid()) {
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
        $client->setSecret(md5($values['name'] . time()));
        $em = $this->getDoctrine()->getManager();
        $em->persist($client);
        $em->flush();

        $this->addFlash('notice', 'A new client was saved');
        return $this->redirectToRoute('client_overview');
      } else {
      /* Form is not (yet) valid */
        return $this->render('HedgeCommEmailBundle:Client:create.html.twig', array('form' => $form->createView()));
      }
    }
    
    /* CLIENT EDIT */
    public function editClientAction(Request $request, $id) {
      $client = $this->getDoctrine()
        ->getRepository('HedgeCommEmailBundle:Client')
        ->find($id);
      if (!$client) {
        throw $this->createNotFoundException('No client found for id ' . $id);
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
        $client = $em->getRepository('HedgeCommEmailBundle:Client')->find($id);
        if (!$client) {
          throw $this->createNotFoundException('No client found for id '.$id);
        }
        $client->setName($values['name']);
        $client->setFromName($values['fromName']);
        $client->setFromEmail($values['fromEmail']);
        $client->setReplyTo($values['replyTo']);
        $em->flush();
        $this->addFlash('notice', 'Client was updated');
        return $this->redirectToRoute('client_overview');
      }
      return $this->render('HedgeCommEmailBundle:Client:edit.html.twig', array('form' => $form->createView()));
    }
    
    /* CLIENT DELETE */
    public function deleteClientAction($id) {
      $em = $this->getDoctrine()->getManager();
      $client = $em->getRepository('HedgeCommEmailBundle:Client')->find($id);
      if (!$client) {
        throw $this->createNotFoundException('No client found for id '.$id);
      }
      $em->remove($client);
      $em->flush();
      $this->addFlash('notice', 'Client was deleted');
      return $this->redirectToRoute('client_overview');
    }

    /* LIST OVERVIEW */
    public function subscriberListOverviewAction() {
      $subscriberlists = $this->getDoctrine()->getRepository('HedgeCommEmailBundle:SubscriberList')->findAll();
      return $this->render('HedgeCommEmailBundle:List:overview.html.twig', array('subscriberlists' => $subscriberlists));
    }
    
    /* CREATE LIST */
    public function createSubscriberListAction(Request $request) {
      $subscriberList = new SubscriberList();
      $form = $this->createForm(new SubscriberListType(), $subscriberList)->add('save', 'submit');
      $form->handleRequest($request);
      /* Form is valid */
      if ($form->isValid()) {
        $values = array(
          'name' => $form->get('name')->getData(),
          'client_id' => $form->get('clientId')->getData(),
        );
        $subscriberList = new SubscriberList();
        $subscriberList->setName($values['name']);
        $subscriberList->setClientId($values['client_id']);
        $em = $this->getDoctrine()->getManager();
        $em->persist($subscriberList);
        $em->flush();

        $this->addFlash('notice', 'A new subscriber list was saved');
        return $this->redirectToRoute('subscriberlist_overview');
      } else {
      /* Form is not (yet) valid */
        return $this->render('HedgeCommEmailBundle:List:create.html.twig', array('form' => $form->createView()));
      }
	    
    }
}
