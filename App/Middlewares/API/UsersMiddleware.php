<?php

namespace App\Middlewares\API;
use Symfony\Component\HttpFoundation\Request;
class UsersMiddleware
{

    public function handle(Request $request)
    {
        return true;
    }

}

?>
