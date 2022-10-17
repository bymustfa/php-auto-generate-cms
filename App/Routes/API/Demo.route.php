<?php

$controllerName = "API.DemoController";
$routerPrefix = "/demo";

$router->get($routerPrefix."/getAll", $controllerName . '@GetAll');

?>
