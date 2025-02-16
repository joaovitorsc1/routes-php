<?php

declare(strict_types=1);

namespace Project\Routesphp\App\Middlewares;

use Project\Routesphp\App\Interfaces\MiddlewareInterface;

class AuthMiddleware implements MiddlewareInterface
{
    public function handle()
    {
        echo "Auth Middleware";
    }
}
?>
