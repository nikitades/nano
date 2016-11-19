<?php

use app\system\Async;
use app\system\Flash;
use app\system\System;
use app\system\View;

function dosf($function_name = false)
{
    dd('Don\'t overload system functions! Function: ' . ($function_name ?: ''));
}

function dd()
{
    $args = func_get_args();
    var_dump(sizeof($args) > 1 ? $args : $args[0]);
    die();
}

if (function_exists('register')) dosf('register');
else {
    function reg($key, $value = false)
    {
        if ($value !== false) return System::$register[$key] = $value;
        else return System::$register[$key];
    }
}

if (function_exists('response')) dosf('response');
else {
    function response($response = false)
    {
        if ($response !== false) {
            switch (true) {
                case $response instanceof View:
                    if (reg('db_used')) header("Expires: Thu, 01 Jan 1970 00:00:01 GMT");
                    $response->appear();
                    break;
                case $response instanceof Async:
                    //TODO: Implement an AJAX response here
                    break;
            }
        }
    }
}

if (function_exists('view')) dosf('view');
else {
    function view($name, Array $data = [])
    {
        return new View($name, $data);
    }
}

if (function_exists('reg_with')) dosf('reg_with');
else {
    function reg_with($with)
    {
        foreach ($with as $category_name => $content) {
            switch ($category_name) {
                case 'flash':
                    foreach ($content as $item) {
                        $message = explode('::', $item);
                        $type = sizeof($message) == 2 ? $message[0] : 'info';
                        Flash::message($type, $message[1]);
                    }
                    break;
                case 'form_data':
                    Flash::data($content);
                    break;
            }
        }
    }
}

if (function_exists('go')) dosf('go');
else {
    function go($where, $with = [])
    {
        reg_with($with);
        header("Location: {$where}");
        DIE('die.');
    }
}

if (function_exists('back')) dosf('back');
else {
    function back($with = [], $where = false)
    {
        reg_with($with);
        $where = $_SERVER['HTTP_REFERER'] ?: $where ?: '/';
        header("Location: {$where}");
        DIE('DIIIIIIIIIIIIIIIIIE');
    }
}
