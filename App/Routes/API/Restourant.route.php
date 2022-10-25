<?php

$controllerName = "API.DemoController";

$routerPrefix = "/restourants";

$router->get($routerPrefix . "/getAll", $controllerName . '@GetAll');

?>
