<?php

namespace app\system;

class Path
{
    public static function track($path, $function, $type = 'get')
    {
        System::$request->paths[strtoupper($type)][$path] = $function;
    }
}