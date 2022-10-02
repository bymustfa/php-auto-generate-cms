<?php

$app->router->group("/content", function ($router) {
    $router->get("/list", 'ContentController@list');
    $router->get("/create", 'ContentController@createPage');
    $router->post("/create", 'ContentController@create');
});


?>
