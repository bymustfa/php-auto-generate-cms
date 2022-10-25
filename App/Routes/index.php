<?php


$routerFiles = [
    'content_management' => __DIR__ . '/ContentManagement.route.php',
    'content_builder' => __DIR__ . '/ContentBuilder.route.php',
    'media' => __DIR__ . '/MediaLibrary.route.php',
    'api_index' => __DIR__ . '/API/index.route.php',
    'setup_index' => __DIR__ . '/SETUP/setup.route.php'
];

$app->router->get('/', function () {
    echo "RUN REACT PREOJECT";
});

$app->router->group("/app", function ($router) use ($routerFiles) {
    $router->group('/content-management', function ($router) use ($routerFiles) {
        file_exists($routerFiles['content_management']) && require_once $routerFiles['content_management'];
    });

    $router->group('/content-builder', function ($router) use ($routerFiles) {
        file_exists($routerFiles['content_builder']) && require_once $routerFiles['content_builder'];
    });

    $router->group('/media-library', function ($router) use ($routerFiles) {
        file_exists($routerFiles['media']) && require_once $routerFiles['media'];
    });

    file_exists(__DIR__ . "/AppOther.route.php") && require_once __DIR__ . "/AppOther.route.php";
});



file_exists($routerFiles['api_index']) && require $routerFiles['api_index'];
file_exists($routerFiles['setup_index']) && require $routerFiles['setup_index'];

require __DIR__ ."/RouteErrors.php";


?>

