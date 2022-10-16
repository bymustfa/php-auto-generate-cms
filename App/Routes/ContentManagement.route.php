<?php

$controllerName = "ContentManagementController";

$router->get('/getAll', $controllerName . '@GetAll');
$router->get('/getOne/:id', $controllerName . '@GetOne');
$router->get('/getTypes', $controllerName . '@GetTypes');

?>
