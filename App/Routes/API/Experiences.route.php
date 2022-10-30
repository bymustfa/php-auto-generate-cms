<?php

$controllerName = "API.ExperiencesController";
$beforeMiddleware = "API\ExperiencesMiddleware";
$routerPrefix = "/experiences";

$router->get(   $routerPrefix . "/getAll",      $controllerName . '@GetAll',     ['before' => $beforeMiddleware]);
$router->get(   $routerPrefix . "/getOne/:id",  $controllerName . '@GetOne',     ['before' => $beforeMiddleware]);
$router->post(  $routerPrefix . "/create",      $controllerName . '@Create',     ['before' => $beforeMiddleware]);
$router->post(  $routerPrefix . "/createMulti",  $controllerName . '@CreateMulti', ['before' => $beforeMiddleware]);
$router->put(   $routerPrefix . "/update/:id",  $controllerName . '@Update',     ['before' => $beforeMiddleware]);
$router->delete($routerPrefix . "/delete/:id",  $controllerName . '@Delete',     ['before' => $beforeMiddleware]);
$router->post(  $routerPrefix . "/filter",      $controllerName . '@Filter',     ['before' => $beforeMiddleware]);

?>
