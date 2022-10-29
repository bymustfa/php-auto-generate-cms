<?php

$controllerName = "ContentManagementController";

$router->post('/create', $controllerName . '@Create');
$router->get('/getAll', $controllerName . '@GetAll');
$router->get('/getOne/:string', $controllerName . '@GetOne');

?>
