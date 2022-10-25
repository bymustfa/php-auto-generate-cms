<?php


$app->router->group("/api", function ($router) {

    $dir = __DIR__ . '/';
    $files = scandir($dir);
    $files = array_diff($files, ['.', '..', 'index.route.php']);
    $files = array_values($files);

    $router->get("/", function () {
        response([
            'status' => true,
            'message' => 'WELCOME API',
            'version' => config("APP_VERSION")
        ]);
    });


    foreach ($files as $file) {
        $file = $dir . $file;
        if (file_exists($file)) {
            require $file;
        }
    }

});

?>
