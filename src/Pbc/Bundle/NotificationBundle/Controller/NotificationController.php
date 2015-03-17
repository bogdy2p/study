<?php

namespace Pbc\Bundle\NotificationBundle\Controller;

class NotificationController {

    private $defaults = array(
                "type" => "flash",
                    ),
            $flashes = array();

    /**
     * Depending on the argument , add the values to the session flashBag or $this->flashes
     * 
     * @param string $name
     * @param array $arguments
     */
    public function add($name, array $arguments = array()) {

        $arguments += $this->defaults;
        // If the type is flash then add the values to the session flashBag
        if ($arguments["type"] === "flash") {
            $this->session->getFlashBag()->add($name, $arguments);
        }
        // Otherwise (is instant) then add them to the class variable $flashes
        elseif ($arguments["type"] === "instant") {
            //We want to be able to have multiple notifications of the same name i.e "success" so we need to ad each new sset of arguments into an array not overwrite the last one
            if (!isset($this->flashes[$name])) {
                $this->flashes[$name] = array();
            }
            $this->flashes[$name][] = $arguments;
        }
    }

}
