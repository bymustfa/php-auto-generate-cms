<?php

namespace App\Controllers;

use App\Models\SuperAdmin;
use Symfony\Component\HttpFoundation\Request;
use Core\Controller;

class BackendController extends Controller
{
    public function Login(Request $request)
    {
        $headers = $request->headers->all();
        try {
            $userName = post("username");
            $password = post("password");

            $superAdmin = SuperAdmin::where('superadmin_name', $userName)->first();

            if ($superAdmin) {
                $passwordControl = passwodVerify($password, $superAdmin->superadmin_password);
                if ($passwordControl) {
                    auth()->create("superadmin_login", true);
                    auth()->create("superadmin_id", $superAdmin->id);


                } else {
                    throw new \Exception("Kullanıcı adı veya şifre hatalı");
                }
            } else {
                throw new \Exception("Kullanıcı adı veya şifre hatalı");
            }

        } catch (\Exception $e) {
            controllerResponse($headers, $e->getMessage(), null, 'danger');
        }
    }

}


?>
