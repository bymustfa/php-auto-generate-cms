<?php

use Symfony\Component\HttpFoundation\Response;

$app->router->group('/doc', function ($router) {
    $router->get('/', function () {
        include __DIR__ . "/Doc/index.php";
    });

    $router->get('/generate.json', function (Response $response) {

        $openapi = \OpenApi\Generator::scan([
            __DIR__ . "/../../Core/Controller.php",
            __DIR__ . "/../Controllers"
        ]);

        $response->headers->set('Content-Type', 'application/json');
        $response->setContent($openapi->toJson());
        $response->send();
        exit();


    });

});

?>
