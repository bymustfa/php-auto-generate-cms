<?php

$controllerName = "API.DemoController";
$routerPrefix = "/demo";

$router->get($routerPrefix."/get-all", $controllerName . '@GetAll');

?>
