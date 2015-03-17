<?php

namespace Pbc\Bundle\NotificationBundle\Twig;

use Symfony\Component\DependencyInjection\ContainerInterface;

class NotificationExtension extends \Twig_Extension {

    protected $container, $notify;

    public function __construct(ContainerInterface $container = null) {
        
        $this->container = $container;
        $this->notify = $container->get("pbc.notify");
    }






    public function getName() {

        return 'pbc_notification_extension';
    }

}
