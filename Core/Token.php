<?php

namespace Core;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Token
{

    public function generate($payload = [])
    {
        $key = config("SECRET_KEY");
        $token = JWT::encode($payload, $key, 'HS256');
        return $token;
    }

    public function decode($token)
    {
        $key = config("SECRET_KEY");
        $decoded = JWT::decode($token, new Key($key, 'HS256'));
        return $decoded;
    }
}
