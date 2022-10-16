<?php

namespace App\Controllers\SETUP;

use App\Models\SuperAdmin;
use Core\Controller;
use Symfony\Component\HttpFoundation\Request;

class SetupController extends Controller
{

    public function DatabaseSetup(Request $request)
    {
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
                response([
                    'status' => true,
                    'message' => 'Database Setup Success'
                ]);
            } else {
                response([
                    'status' => true,
                    'message' => 'Database Setup Failed'
                ], 500);
            }
        } catch (\Exception $e) {
            response([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public function SuperAdminSetup(Request $request)
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
                `superadmin_status` tinyint(1) NOT NULL DEFAULT '1',
                `superadmin_token` text NOT NULL,                
              ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

                $token = md5(uniqid());

                sql("INSERT INTO $adminTableName SET superadmin_name = '$adminName', superadmin_password= '$adminPassword', superadmin_token = '$token' ");

                response([
                    'status' => true,
                    'message' => 'Admin Setup Success'
                ]);


            }
        } catch (\Exception $e) {
            response([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public function RolesSetup(Request $request)
    {
        echo "Roles Setup";
    }


    public function FinishSetup(Request $request)
    {

        $headers = $request->headers->all();
        try {

            $mediaLibraryCreateTableSql = "CREATE TABLE if NOT EXISTS media_library(
                    `id` INT(11) NOT NULL AUTO_INCREMENT,
                    `media_guid` VARCHAR(400) NOT NULL,
                    `media_name` VARCHAR(400) NOT NULL,
                    `media_type` VARCHAR(100) NOT NULL,
                    `media_ext` VARCHAR(100) NOT NULL,
                    `media_path` TEXT NOT NULL,
                    `media_size` VARCHAR(100) NOT NULL,
                    `media_status` TINYINT(1) NOT NULL DEFAULT '1',
                    `media_created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
                    `media_updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP() ON UPDATE CURRENT_TIMESTAMP(),
                     PRIMARY KEY(`id`)
                ) 
                 CHARSET = utf8 AUTO_INCREMENT = 1;
                  ";

            sql($mediaLibraryCreateTableSql);

            response([
                'status' => true,
                'message' => 'Assets Setup Success'
            ]);


        } catch (\Exception $e) {
            response([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);

        }
    }

}

?>
