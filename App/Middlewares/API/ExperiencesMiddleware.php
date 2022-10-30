<?php

namespace App\Middlewares\API;
use Symfony\Component\HttpFoundation\Request;
class ExperiencesMiddleware
{

    public function handle(Request $request)
    {
        return true;
    }

}

?>
