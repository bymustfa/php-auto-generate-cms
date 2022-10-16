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

            $entityBody = json_decode($request->getContent(), true);
            $db["host"] = isset($entityBody["host"]) ? dataClear($entityBody["host"]) : config("DB_HOST");
            $db["user"] = isset($entityBody["user"]) ? dataClear($entityBody["user"]) : config("DB_USER");
            $db["password"] = isset($entityBody["password"]) ? dataClear($entityBody["password"]) : config("DB_PASSWORD");
            $db["database"] = isset($entityBody["database"]) ? dataClear($entityBody["database"]) : config("DB_NAME");
            $db["prefix"] = isset($entityBody["prefix"]) ? dataClear($entityBody["prefix"]) : config("DB_PREFIX");


            $dbEnv = "<?php  \$dbENV = [
    'DB_HOST' => '" . $db["host"] . "',
    'DB_NAME' => '" . $db["database"] . "',
    'DB_USER' => '" . $db["user"] . "',
    'DB_PASSWORD' => '" . $db["password"] . "',
    'DB_PREFIX' => '" . $db["prefix"] . "',
]; ?>";

            $dbFilePath = __DIR__ . '/../../../ENV/db.env.php';

            $write = file_put_contents($dbFilePath, $dbEnv);
            if ($write) {
                response([
                    'status' => true,
                    'message' => 'Database Setup Success'
                ]);
            } else {
                throw new \Exception("Database Setup Failed");
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
        try {

            $entityBody = json_decode($request->getContent(), true);

            $adminName = isset($entityBody["name"]) ? dataClear($entityBody["name"]) : "admin";
            $adminPassword = isset($entityBody["password"]) ? dataClear($entityBody["password"]) : "admin";
            $adminPassword = passwordHash($adminPassword);
            $adminTableName = "super_admin";

            $adminExistSql = sql("SELECT * FROM information_schema.tables WHERE table_schema = '" . config("DB_NAME") . "' AND table_name = '$adminTableName' LIMIT 1");


            $token = md5(uniqid());

            $insertSQL = "INSERT INTO $adminTableName SET superadmin_name = '$adminName', superadmin_password= '$adminPassword', superadmin_token = '$token' ";


            if ($adminExistSql && count($adminExistSql) > 0) {
                // truncate table
                sql("TRUNCATE TABLE $adminTableName");
                sql($insertSQL);

                response([
                    'status' => true,
                    'message' => 'Super Admin Setup Success'
                ]);
            } else {

                $createSQL = "CREATE TABLE IF NOT EXISTS `super_admin`(
                        `id` INT(11) NOT NULL AUTO_INCREMENT,
                        `superadmin_name` VARCHAR(100) NOT NULL,
                        `superadmin_password` TEXT NOT NULL,
                        `superadmin_status` TINYINT(1) NOT NULL DEFAULT '1',
                        `superadmin_token` TEXT NOT NULL,
                        PRIMARY KEY(`id`)
                    ) CHARSET = utf8 AUTO_INCREMENT = 1;";


                sql($createSQL);
                sql($insertSQL);

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
        try {

            $mediaLibraryCreateTableSql = "CREATE TABLE if NOT EXISTS media_library(
                    `id` INT(11) NOT NULL AUTO_INCREMENT,
                    `media_guid` VARCHAR(400) NOT NULL,
                    `media_name` VARCHAR(400) NOT NULL,
                    `media_type` VARCHAR(100) NOT NULL,
                    `media_ext` VARCHAR(100) NOT NULL,
                    `media_paths` TEXT NOT NULL,
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
                'message' => 'Media Library Setup Success'
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
