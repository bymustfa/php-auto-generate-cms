<?php
$app->router->post("/restaurants", "CMS.RestaurantsController@create");
$app->router->post("/restaurants/filter", "CMS.RestaurantsController@filter");
$app->router->get("/restaurants/:id", "CMS.RestaurantsController@getByID");
$app->router->get("/restaurants", "CMS.RestaurantsController@getAll");
$app->router->put("/restaurants/:id", "CMS.RestaurantsController@update");
$app->router->delete("/restaurants/:id", "CMS.RestaurantsController@delete");

?>
