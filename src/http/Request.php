<?php

declare(strict_types=1);

namespace Project\Routesphp\Http;

class Request
{
    public static function getUri()
    {
        return parse_url(rtrim($_SERVER["REQUEST_URI"], "/"), PHP_URL_PATH);
    }

    public static function getMethod()
    {
        return $_SERVER["REQUEST_METHOD"];
    }
}
?>
