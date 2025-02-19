<?php

declare(strict_types=1);

namespace Project\Routesphp\Config;

use Project\Routesphp\Http\Request;
use Project\Routesphp\Http\Response;

class Core
{
    public function dispatch(array $routes, array $middlewareList)
    {
        $uri = $_GET["uri"] ?? "/";

        $uri !== "/" && $uri = rtrim($_GET["uri"], "/");

        foreach($routes as $route)
        {
            $routeUri = $route["uri"] ?? "";
            $routeUri !== "/" && $routeUri = trim($route["uri"], "/");

            $routerFound = false;

            $pattern = "#^" . preg_replace("(:any)", "[\w\-]+", $routeUri) . "$#";
            if(preg_match($pattern, $uri, $matches))
            {
                $routerFound = true;

                if(Request::getMethod() !== $route["method"])
                {
                    Response::json([
                        "status" => "error",
                        "message" => "Method Not Allowed"
                    ], 405);
                }

                array_shift($matches);
                $parameters     = $matches;
                $middlewares    = $route["middlewares"];
                $options        = $route["options"];

                if(!empty($middlewares))
                {
                    $this->handleMiddleware($middlewares, $middlewareList, $options, $parameters);
                } else
                {
                    $this->handleController($options, $parameters);
                }
                return;
            }
        }
        
        if(!$routerFound)
        {
            Response::json([
                "status" => "error",
                "message" => "Router Not Found"
            ], 404);
        }
    }

    public function handleMiddleware(array $middlewares, array $middlewareList, array $options, array $parameters)
    {
        foreach($middlewares as $middleware)
        {
            if(array_key_exists($middleware, $middlewareList))
            {
                $middlewareClass = $middlewareList[$middleware];
                $middlewareObj   = new $middlewareClass;
                $middlewareObj->handle();
            }
        }

        $this->handleController($options, $parameters);
    }

    public function handleController(array $options, array $parameters)
    {
        [$controller, $method] = $options;
        $containerDependency = ContainerDependency::get($controller);
        $containerDependency->$method(...$parameters);
    }
}
?>