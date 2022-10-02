<?php

namespace App\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Core\Controller;
use App\Models\SuperAdmin;

class SetupController extends Controller
{

    public function list()
    {
        return $this->view('setup/list');
    }

    public function db()
    {
        return $this->view('setup/db');
    }

    public function admin()
    {
        $superAdmin =SuperAdmin::get()->first();
        return $this->view('setup/admin', compact('superAdmin'));
    }

    public function dbSave(Request $request)
    {
        $headers = $request->headers->all();
        try {
            $db["host"] = post("host");
            $db["user"] = post("user");
            $db["password"] = post("password");
            $db["database"] = post("database");
            $db["prefix"] = post("prefix");

            $db["host"] = $db["host"] ? $db["host"] : config("DB_HOST");
            $db["user"] = $db["user"] ? $db["user"] : config("DB_USER");
            $db["password"] = $db["password"] ? $db["password"] : config("DB_PASSWORD");
            $db["database"] = $db["database"] ? $db["database"] : config("DB_NAME");
            $db["prefix"] = $db["prefix"] ? $db["prefix"] : config("DB_PREFIX");


            $dbEnv = "<?php 
    \$dbENV = [
        'DB_HOST' => '" . $db["host"] . "',
        'DB_NAME' => '" . $db["database"] . "',
        'DB_USER' => '" . $db["user"] . "',
        'DB_PASSWORD' => '" . $db["password"] . "',
        'DB_PREFIX' => '" . $db["prefix"] . "',
    ];
    ?>";

            $write = file_put_contents(__DIR__ . '/../../ENV/db.env.php', $dbEnv);
            if ($write) {
                controllerResponse($headers, "Database Setup Success");
            } else {
                controllerResponse($headers, "Database Setup Failed", 500);
            }
        } catch (\Exception $e) {
            controllerResponse($headers, $e->getMessage(), 500);
        }
    }


    public function adminSave(Request $request)
    {
        $headers = $request->headers->all();

        try {
            $adminName = post("name");
            $adminPassword = post("password");

            $adminName = $adminName ? $adminName : "admin";
            $adminPassword = $adminPassword ? $adminPassword : "admin";
            $adminPassword = passwordHash($adminPassword);
            $adminTableName = "super_admin";

            $adminExistSql = sql("SELECT * FROM information_schema.tables WHERE table_schema = '" . config("DB_NAME") . "' AND table_name = '$adminTableName' LIMIT 1");

            if ($adminExistSql) {
                // truncate table
                sql("TRUNCATE TABLE $adminTableName");
                sql("INSERT INTO $adminTableName SET superadmin_name = '$adminName', superadmin_password= '$adminPassword' ");
                controllerResponse($headers, "Admin Setup Success");
            } else {
                sql("CREATE TABLE `$adminTableName` (
                `id` int(11) NOT NULL,
                `superadmin_name` varchar(100) NOT NULL,
                `superadmin_password` text NOT NULL,
                `superadmin_status` tinyint(1) NOT NULL DEFAULT '1'
              ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

                sql("INSERT INTO $adminTableName SET superadmin_name = '$adminName', superadmin_password= '$adminPassword' ");
                controllerResponse($headers, "Admin Setup Success");


            }
        } catch (\Exception $e) {
            controllerResponse($headers, $e->getMessage(), 500);
        }
    }
}

?>
