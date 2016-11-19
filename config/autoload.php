<?php

require "../config/static.php";
require "../helpers/dpl.php";
require "../helpers/functions.php";
require "../helpers/view_functions.php";
require "../config/config.php";

const PHP_EXT = '.php';

function autoload($class)
{
    $unslashed_path = '..' . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $class) . PHP_EXT;
    $realpath = realpath($unslashed_path);
    if (file_exists($realpath)) require $realpath;
    else throw new Exception('Class ' . $class . ' not found!');
}

function files()
{
    return glob('../app/*/*.php');
}

function namespaced(&$class)
{
    if (empty($class)) return false;
    $class = explode('\\', $class);
    $class = array_shift($class);
    foreach (files() as $filepath) {
        if (strpos($filepath, $class)) return $class = str_replace('/', '\\', substr($filepath, 3, -4));
    }
    return false;
}

spl_autoload_register('autoload');