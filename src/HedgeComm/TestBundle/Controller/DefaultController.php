<?php

namespace HedgeComm\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('HedgeCommTestBundle:Default:index.html.twig', array('name' => $name));
    }
    
    public function testAction() {
      return $this->render('HedgeCommTestBundle:Default:test.html.twig');
    }
}
