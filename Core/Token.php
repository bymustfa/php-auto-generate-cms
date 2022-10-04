<?php

namespace Core;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Token
{

    private static $instance;


    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new Token();
        }
        return self::$instance;
    }

    public function generate($payload = [])
    {
        $key = config("SECRET_KEY");
        return JWT::encode($payload, $key, 'HS256');

    }

    public function decode($token)
    {
        $key = config("SECRET_KEY");
        return JWT::decode($token, new Key($key, 'HS256'));

    }
}
