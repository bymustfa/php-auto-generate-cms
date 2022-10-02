<?php

namespace App\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Core\Controller;

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
}

?>
