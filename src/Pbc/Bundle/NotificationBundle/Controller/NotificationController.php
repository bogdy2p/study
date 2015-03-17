<?php

namespace Pbc\Bundle\NotificationBundle\Controller;

class NotificationController {

    private $defaults = array(
                "type" => "flash",
                    ),
            $flashes = array(),
            $session;

    /**
     * @param \Symfony\Component\HttpFoundation\Session\Session $session
     */
    public function __construct(\Symfony\Component\HttpFoundation\Session\Session $session) {
        $this->session = $session;
    }

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

    /**
     * Check the flashBag and $this->flashes for existence of $name
     * @param type $name
     * @return boolean
     */
    public function has($name) {
        if ($this->session->getFlashBag()->has($name)) {
            return true;
        } else {
            return isset($this->flashes[$name]);
        }
    }

    /**
     * Search for a specific notification and return matches from flashBag and $this->flashes
     * @param type $name
     * @return type
     */
    public function get($name) {
        if ($this->session->getFlashBag()->has($name) && isset($this->flashes[$name])) {
            return array_merge_recursive($this->session->getFlashBag()->getName(), $this->flashes[$name]);
        } elseif ($this->session->getFlashBag()->has($name)) {
            return $this->session->getFlashBag()->get($name);
        } else {
            return $this->flashes[$name];
        }
    }

    /**
     * Merge all flashBag and $this->flashes values and return the array
     * @return array
     */
    public function all() {
        return array_merge_recursive($this->session->getFlashBag()->all(), $this->flashes);
    }

}
