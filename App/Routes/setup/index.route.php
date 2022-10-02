<?php

use Symfony\Component\HttpFoundation\Request;

$app->router->group("/setup", function ($router) {
    $router->get("/", 'SetupController@list');

    $router->get("/db", 'SetupController@db');

    $router->post("/db", 'SetupController@dbSave');

    $router->get("/admin", 'SetupController@admin');

    $router->post("/admin",'SetupController@adminSave');


});
