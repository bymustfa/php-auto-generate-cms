<?php
$app->router->group("/api", function ($router) {

    if (file_exists(__DIR__ . '/Restaurants.route.php')) {
        require __DIR__ . '/Restaurants.route.php';
    }
});

?>

