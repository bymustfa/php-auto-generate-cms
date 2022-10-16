<?php

namespace App\Middlewares;

use App\Models\SuperAdmin;

class SuperAdminAuth
{

    public function handle()
    {
        // TODO: SuperAdminAuth roles and permissions here
        return true;
    }

}

?>
