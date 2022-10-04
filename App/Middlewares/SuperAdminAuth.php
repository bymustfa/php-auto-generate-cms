<?php

namespace App\Middlewares;

class SuperAdminAuth
{

    public function handle()
    {
        if (sesion()->get('superadmin_login') && sesion()->get('superadmin_id')) {
            return true;
        } else {
            redirect(base_url('login'));
            return false;
        }
    }

}

?>
