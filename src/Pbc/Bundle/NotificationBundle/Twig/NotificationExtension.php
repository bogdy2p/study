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

    public function getFunctions() {

        return array(
            'notify_all' => new \Twig_Function_Method($this, 'renderAll', array('is_safe' => array('html'))),
            'notify_one' => new \Twig_Function_Method($this, 'renderOne', array('is_safe' => array('html'))),
            'notify_resources' => new \Twig_Function_Method($this, 'renderResources', array('is_safe' => array('html')))
        );
    }

    public function renderResources() {
        return $this->container->get('templating')
                        ->render("PbcNotificationBundle:Notification:resources.html.twig");
    }

    public function getName() {

        return 'pbc_notification_extension';
    }

    public function load(array $configs, ContainerBuilder $container){
        
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        
        $container->setParameter("pbc.notify.message", $config["message"]);
        $container->setParameter("pbc.notify.title", $config["title"]);
        $container->setParameter("pbc.notify.class", $config["class"]);
        $container->setParameter("pbc.notify.type", $config["type"]);
        $container->setParameter("pbc.notify.lifetime", $config["lifetime"]);
        $container->setParameter("pbc.notify.click_to_close", $config["click_to_close"]);
        
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
        
    }
    
}
