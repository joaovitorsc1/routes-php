<?php

declare(strict_types=1);

namespace Project\Routesphp\Http;

class Response
{
    public static function json(array $data, int $status = 200)
    {
        header("Content-Type: application/json");
        $data["status"] = $status;
        echo json_encode($data);
    }
}
?>