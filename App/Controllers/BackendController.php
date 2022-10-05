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

            $remember = post("remember");


            $superAdmin = SuperAdmin::where('superadmin_name', $userName)->first();

            if ($superAdmin) {
                $passwordControl = passwodVerify($password, $superAdmin->superadmin_password);
                if ($passwordControl && $superAdmin->superadmin_status == 1) {
                    sesion()->create("superadmin_login", true);
                    sesion()->create("superadmin_id", $superAdmin->id);
                    sesion()->create("superadmin_name", $superAdmin->superadmin_name);


                    if ($remember) {
                        $rememberToken = createToken(['superadmin_id' => $superAdmin->id, 'token' => $superAdmin->superadmin_token]);
                        $expire = time() + 60 * 60 * 24;
                        setcookie("remember_superadmin_token", $rememberToken, time() + $expire, "/");
                    } else {
                        setcookie("remember_superadmin_token", "", time() - 3600, "/");
                    }

                    redirect(base_url());


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

    public function Logout()
    {
        sesion()->remove('superadmin_login');
        sesion()->remove('superadmin_id');
        sesion()->remove('superadmin_name');
        setcookie("remember_superadmin_token", "", time() - 3600, "/");
        redirect(base_url('login'));
    }


}


?>
