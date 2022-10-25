<?php


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


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
