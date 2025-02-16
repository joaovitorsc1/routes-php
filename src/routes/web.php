<?php

use Project\Routesphp\Config\Core;
use Project\Routesphp\Http\Routes;
use Project\Routesphp\Config\ContainerDependency;
use Project\Routesphp\App\Controllers\HomeController;

// Add Routes GET
Routes::get("/users/(:id)", [HomeController::class, "index"])->middleware("auth");

// List All Middlewares
$listMiddlewares = require_once __DIR__ . "/../config/Middlewares.php";

// Dispatch All Routes
$core = new Core;
$core->dispatch(Routes::returnRoutes(), $listMiddlewares);

?>