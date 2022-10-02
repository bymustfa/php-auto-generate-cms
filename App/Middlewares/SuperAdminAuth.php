<?php

namespace App\Middlewares;

class SuperAdminAuth
{

    public function handle()
    {
        if (auth()->get('superadmin_login') && auth()->get('superadmin_id')) {
            return true;
        } else {
            message('Lütfen giriş yapınız', 'danger');
            redirect(base_url('login'));
            return false;
        }
    }

}

?>
