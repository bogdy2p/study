<?php

namespace Pbc\Bundle\NotificationBundle\Twig;

use Symfony\Component\DependencyInjection\ContainerInterface;

class NotificationExtension extends \Twig_Extension {

    protected $container, $notify;

    public function __construct(ContainerInterface $container = null) {

        $this->container = $container;
        $this->notify = $container->get("pbc.notify");
    }

    public function renderAll($container = false) {

        $notifications_array = $this->notify->all();

        if (count($notifications_array) > 0) {
            return $this->container->get('templating')
                            ->render(
                                    "PbcNotificationBundle:Notification:multiple.html.twig", compact("notifications_array", "container")
            );
        }
        return null;
    }

    public function renderOne($name, $container = false) {

        if (!$this->notify->has($name)) {
            return false;
        }
        $notifications = $this->notify->get($name);

        if (count($notifications) > 0) {
            return $this->container->get('templating')
                            ->render(
                                    "PbcNotificationBundle:Notification:single.html.twig", compact("notifications" . "container")
            );
        }
        return null;
    }

    public function getName() {

        return 'pbc_notification_extension';
    }

}
