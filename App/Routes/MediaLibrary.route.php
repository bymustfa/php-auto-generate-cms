<?php
$controllerName = "MediaLibraryController";


$router->get('/getAll', $controllerName . '@GetAll', ['before' => 'MediaLibrary']);
$router->get('/getOne/:id', $controllerName . '@GetOne', ['before' => 'MediaLibrary']);
$router->post('/add', $controllerName . '@AddMedia', ['before' => 'MediaLibrary']);
$router->delete('/delete/:id', $controllerName . '@DeleteMedia', ['before' => 'MediaLibrary']);


?>
