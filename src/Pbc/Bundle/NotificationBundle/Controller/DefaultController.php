<?php

namespace Pbc\Bundle\NotificationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/testing/notifications")
     * @Template()
     */
    public function indexAction()
    {
        $notify = $this->get("pbc.notify");
        $notify->add("test", array("type" => "instant", "message" => "this is awesome"));
        $notify->add("asd", array("type" => "instant", "message" => "this is not awesome"));
        $notify->add("asd2", array("type" => "instant", "message" => "Lolozaur :) "));
        $notify->add("asd3", array("type" => "instant", "message" => "~AwEsOmE~"));
        
        
        
        if($notify->has("test")) {
            return array("notifications" => $notify->get("test"));
        }
        return array();
    }
}
