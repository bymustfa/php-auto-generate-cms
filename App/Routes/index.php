<?php


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;



$app->router->group("/", function ($router) {
    $router->get('/', 'FrontController@Index');
}, ['before' => 'SuperAdminAuth']);


$app->router->get('/login', 'FrontController@Login');
$app->router->post('/login', 'BackendController@Login');


if (file_exists(__DIR__ . '/setup/index.route.php')) {
    require __DIR__ . '/setup/index.route.php';
}


if (file_exists(__DIR__ . '/CMS/index.php')) {
    require __DIR__ . '/CMS/index.php';
}

$app->router->notFound(function (Request $request, Response $response) {
    response([
        'status' => false,
        'message' => 'Page not found',
        'data' => null
    ], 404);
});


$app->router->error(function (Request $request, Response $response, Exception $exception) {
    throw $exception;
});


//    $generator = new \Core\Generator();

//    $rename = $generator->renameTable('lokantalar', 'restaurants');
//
//   response($rename);

//

//    $tableAndModel = $generator->createTable("restaurants", [
//        "name" => [
//            'type' => 'string',
//            'default' => null,
//        ],
//        "stars" => [
//            'type' => 'number',
//            'default' => 1,
//        ],
//        "address" => [
//            'type' => 'string',
//            'default' => null,
//        ],
//        "status" => [
//            'type' => 'boolean',
//            'default' => 1,
//        ],
//    ]);
//
//    echo "<pre>";
//    print_r($tableAndModel);
//    echo "</pre>";
//
//
//    $model = $generator->createModel("restaurants");
//
//    echo "<pre>";
//    print_r($model);
//    echo "</pre>";
//
//    $controller = $generator->createController("Restaurants");
//
//    echo "<pre>";
//    print_r($controller);
//    echo "</pre>";
//
//    $route = $generator->createRoute("restaurants", "Restaurants");
//
//    echo "<pre>";
//    print_r($route);
//    echo "</pre>";

//  $generator->routeIndex();


?>

