<?php

namespace App\Middlewares;

use App\Models\SuperAdmin;

class SuperAdminAuth
{

    public function handle()
    {

        if (sesion()->get('superadmin_login') && sesion()->get('superadmin_id')) {
            return true;
        } else {

            if (isset($_COOKIE['remember_superadmin_token'])) {
                $token = decodeToken($_COOKIE['remember_superadmin_token']);

                if ($token) {
                    $superAdmin = SuperAdmin::where('id', $token->superadmin_id)->first();
                    if ($superAdmin) {
                        if ($superAdmin->superadmin_token == $token->token) {
                            sesion()->create("superadmin_login", true);
                            sesion()->create("superadmin_id", $superAdmin->id);
                            sesion()->create("superadmin_name", $superAdmin->superadmin_name);

                            return true;
                        } else {
                            redirect(base_url('login'));
                            return false;
                        }
                    } else {
                        redirect(base_url('login'));
                        return false;
                    }
                } else {
                    redirect(base_url('login'));
                    return false;
                }

            } else {
                redirect(base_url('login'));
                return false;
            }

        }
    }

}

?>
