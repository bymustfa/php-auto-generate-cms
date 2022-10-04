<?php

namespace Core;

use Aura\Session\Segment;
use Aura\Session\SessionFactory;

class Auth
{

    private static $instance;
    public $segment;

    public function __construct()
    {
        $session_factory = new SessionFactory();
        $session = $session_factory->newInstance($_COOKIE);
        $this->segment = $session->getSegment('Precaumed\Auth');
    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new Auth();
        }
        return self::$instance;
    }


    public function create($key, $value)
    {
        if (is_array($value)) {
            foreach (array_keys($value) as $k) {
                $value[$k] = dataClear($value[$k]);
            }
        } else {
            $value = dataClear($value);
        }
        $this->segment->set($key, $value);
    }

    public function get($key)
    {
        return $this->segment->get($key);
    }

    public function getAll(){
        return $this->segment->get();
    }

    public function allSessionClear()
    {
        $this->segment->clear();
    }

    public function remove($key)
    {
        $this->segment->set($key, null);
    }


    public function guard()
    {
        return $this;
    }


}

?>
