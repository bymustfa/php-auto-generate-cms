<?php

use Symfony\Component\HttpFoundation\Request;

$app->router->group("/setup", function ($router) {
    $router->get("/", 'SetupController@list');


    $router->get("/db", 'SetupController@db');

    $router->post("/db", 'SetupController@dbSave');


    $router->get("/admin", function () {
        include __DIR__ . "/ui/admin.setup.php";
    });

    $router->post("/admin", function () {
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

            echo "Success";

        } else {
            sql("CREATE TABLE `$adminTableName` (
                `id` int(11) NOT NULL,
                `superadmin_name` varchar(100) NOT NULL,
                `superadmin_password` text NOT NULL,
                `superadmin_status` tinyint(1) NOT NULL DEFAULT '1'
              ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

            sql("INSERT INTO $adminTableName SET superadmin_name = '$adminName', superadmin_password= '$adminPassword' ");

            echo "Success";


        }


    });


});
