<?php


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$routerFiles = [
    'content_management' => __DIR__ . '/ContentManagement.route.php',
    'content_builder' => __DIR__ . '/ContentBuilder.route.php',
    'media' => __DIR__ . '/MediaLibrary.route.php',
    'api_index' => __DIR__ . '/API/index.route.php',
    'setup_index' => __DIR__ . '/SETUP/setup.route.php'
];


$app->router->group("/", function ($router) use ($routerFiles) {
    $router->get('/', 'FrontController@Index');

    $router->group('/content-management', function ($router) use ($routerFiles) {
        file_exists($routerFiles['content_management']) && require_once $routerFiles['content_management'];
    });

    $router->group('/content-builder', function ($router) use ($routerFiles) {
        file_exists($routerFiles['content_builder']) && require_once $routerFiles['content_builder'];
    });

    $router->group('/media-library', function ($router) use ($routerFiles) {
        file_exists($routerFiles['media']) && require_once $routerFiles['media'];
    });


});  // ['before' => 'SuperAdminAuth']


$app->router->group('/media-library', function ($router) use ($routerFiles) {
    file_exists($routerFiles['media']) && require_once $routerFiles['media'];
});

file_exists($routerFiles['api_index']) && require $routerFiles['api_index'];
file_exists($routerFiles['setup_index']) && require $routerFiles['setup_index'];


$app->router->notFound(function (Request $request, Response $response) {

    $path = $request->getPathInfo();
    $timeStamp = date('Y-m-d H:i:s');
    $statusCodes = $response->getStatusCode();


    response([
        'status' => false,
        'message' => 'Page not found',
        'data' => [
            'path' => $path,
            'timeStamp' => $timeStamp,
            'statusCodes' => $statusCodes
        ]
    ], 404);
});


$app->router->error(function (Request $request, Response $response, Exception $exception) {

    if (config('DEVELOPMENT')) {
        throw $exception;
    } else {
        $path = $request->getPathInfo();
        $timeStamp = date('Y-m-d H:i:s');
        $statusCodes = $response->getStatusCode();

        response([
            'status' => false,
            'message' => 'Error',
            'data' => [
                'path' => $path,
                'timeStamp' => $timeStamp,
                'statusCodes' => $statusCodes,
                'exception' => $exception
            ]
        ], 500);
    }


});


?>

