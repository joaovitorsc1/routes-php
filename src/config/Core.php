<?php

declare(strict_types=1);

namespace Project\Routesphp\Config;

use Project\Routesphp\Http\Request;
use Project\Routesphp\Http\Response;

class Core
{
    public function dispatch(array $routes, array $listMiddlewares)
    {
        foreach ($routes as $route) 
        {
            $routerFound = false;

            $pattern = "#^" . preg_replace("(:id)", "[\w-]+", rtrim($route["uri"], "/")) . "$#";
            if(preg_match($pattern, Request::getUri(), $matches)) 
            {
                $routerFound = true;

                if(Request::getMethod() !== $route["method"]) 
                {
                    return Response::json(["message" => "Method not allowed"], 405);
                }

                array_shift($matches);
                $parameters  = $matches;
                $options     = $route["options"];
                $middlewares = $route["middleware"];

                if(!empty($middlewares))
                {
                    $this->handleMiddleware($middlewares, $listMiddlewares, $options, $parameters);
                }
            }
        }
        if(!$routerFound) 
        {
            return Response::json(["message" => "Route not found"], 404);
        }
    }

    public function handleMiddleware(array $middlewares, array $listMiddlewares, array $options, array $params)
    {
        foreach($middlewares as $middleware) 
        {
            if(array_key_exists($middleware, $listMiddlewares)) 
            {
                $middleware = $listMiddlewares[$middleware];
                $middlewareObj = new $middleware;
                $middlewareObj->handle();
            }
        }
        $this->handleController($options, $params);
    }

    public function handleController(array $options, array $params)
    {
        [$controller, $method] = $options;
        $controllerInstance = ContainerDependency::get($controller);
        $controllerInstance->$method(...$params);
    }
}
?>