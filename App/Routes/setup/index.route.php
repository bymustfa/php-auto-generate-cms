<?php

use Symfony\Component\HttpFoundation\Request;

$app->router->group("/setup", function ($router) {
    $router->get("/", function () {
        include __DIR__ . "/ui/index.setup.php";
    });


    $router->get("/db", function () {
        include __DIR__ . "/ui/database.setup.php";
    });

    $router->post("/db", function () {
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

        $write = file_put_contents(__DIR__ . '/../../../ENV/db.env.php', $dbEnv);
        if ($write) {
            echo "Success";
        } else {
            echo "Error";
        }
    });


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
