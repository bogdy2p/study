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
        
        if($notify->has("test")) {
            return array("notifications" => $notify->get("test"));
        }
        return array();
    }
}
