<?php

declare(strict_types=1);

namespace Project\Routesphp\Http;

class Routes
{
    private static array $routes;

    public static function get(string $uri, array $options)
    {
        self::$routes[] = [
            "method"        => "GET",
            "uri"           => $uri,
            "options"       => $options,
            "middleware"    => ""
        ];

        return new self;
    }

    public static function post(string $uri, array $options)
    {
        self::$routes[] = [
            "method"        => "POST",
            "uri"           => $uri,
            "options"       => $options,
            "middleware"    => ""
        ];

        return new self;
    }

    public function middleware(...$middlewares)
    {
        self::$routes[array_key_last(self::$routes)]["middleware"] = $middlewares;
    }

    public static function returnRoutes()
    {
        return self::$routes;
    }
}
?>