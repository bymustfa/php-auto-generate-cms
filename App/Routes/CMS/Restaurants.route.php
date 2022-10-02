<?php
$router->post("/restaurants", "CMS.RestaurantsController@create");
$router->post("/restaurants/filter", "CMS.RestaurantsController@filter");
$router->get("/restaurants/:id", "CMS.RestaurantsController@getByID");
$router->get("/restaurants", "CMS.RestaurantsController@getAll");
$router->put("/restaurants/:id", "CMS.RestaurantsController@update");
$router->delete("/restaurants/:id", "CMS.RestaurantsController@delete");

?>
