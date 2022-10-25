<?php

namespace App\Middlewares;

use Symfony\Component\HttpFoundation\Request;

class MediaLibrary
{

    public function handle(Request $request)
    {
//        TODO: path and permissions control
//        $path = $request->getPathInfo();
//        if (strpos($path, "getAll")) {
//            response(['status' => false, "message" => "You are not allowed to access this route"], 403);
//            return false;
//        }

        return true;


    }

}

?>
