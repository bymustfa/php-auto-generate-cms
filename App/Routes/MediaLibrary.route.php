<?php
$controllerName = "MediaLibraryController";


$router->get('/getAll', $controllerName . '@GetAll');
$router->get('/getOne/:id', $controllerName . '@GetOne');
$router->post('/add', $controllerName . '@AddMedia');


?>
