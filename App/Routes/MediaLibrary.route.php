<?php
$controllerName = "MediaLibraryController";

$router->get(   '/getAll',      $controllerName . '@GetAllMedia',             ['before' => 'MediaLibrary']);
$router->get(   '/getOne/:id',  $controllerName . '@GetOneMedia',             ['before' => 'MediaLibrary']);
$router->post(  '/filter',      $controllerName . '@FilterMedia',        ['before' => 'MediaLibrary']);
$router->post(  '/add',         $controllerName . '@AddMedia',           ['before' => 'MediaLibrary']);
$router->delete('/delete/:id',  $controllerName . '@DeleteMedia',        ['before' => 'MediaLibrary']);


?>
