<?php

namespace App\Helpers;

class JsonStorage
{
    public static function read($filename)
    {
        $path = storage_path("json/$filename.json");
        return file_exists($path) ? json_decode(file_get_contents($path), true) : [];
    }

    public static function write($filename, $data)
    {
        $path = storage_path("json/$filename.json");
        file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT));
    }
}
