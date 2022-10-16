<?php


$app->router->group("/setup", function ($router) {
    $controllerName = "SETUP.SetupController";

    $router->post("/database-setup", $controllerName . '@DatabaseSetup');
    $router->post("/superadmin-setup", $controllerName . '@SuperAdminSetup');
    // TODO: Roles setup not finished
    $router->post("/roles-setup", $controllerName . '@RolesSetup');

    $router->get("/finish-setup", $controllerName . '@FinishSetup');
});
