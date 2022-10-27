<?php

namespace App\Middlewares\API;
use Symfony\Component\HttpFoundation\Request;
class RestourantMiddleware
{

    public function handle(Request $request)
    {
        return true;
    }

}

?>
