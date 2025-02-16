<?php

declare(strict_types=1);

namespace Project\Routesphp\App\Controllers;

class HomeController
{
    public function index($param)
    {
        echo "Hello World " . $param;
    }
}
?>