<?php

if (function_exists('nanolink')) dosf('nanolink');
else {
    function nanolink($template_name, $data = [])
    {
        return view($template_name, $data)->appear();
    }
}

if (function_exists('v_clear')) dosf('v_clear');
else {
    function v_clear($str)
    {
        if ($str == '/') return $str == $_SERVER['REQUEST_URI'];
        if ($str[0] == '/') $str = substr($str, 1);
        if ($str[strlen($str) - 1] == '/') $str = substr($str, 0, -1);
        return $str;
    }
}

if (function_exists('curi')) dosf('curi');
else {
    function curi($uri)
    {
        return v_clear($uri) === v_clear($_SERVER['REQUEST_URI']);
    }
}

if (function_exists('curir')) dosf('curir');
else {
    function curir($uri, $replacement)
    {
        return v_clear($uri) === v_clear($_SERVER['REQUEST_URI']) ? $replacement : '';
    }
}

if (function_exists('escape')) dosf('escape');
else {
    function escape($str)
    {
        return htmlspecialchars($str);
    }
}

if (function_exists('safe')) dosf('safe');
else {
    function safe($str, $default = '')
    {
        return (!is_null($str) && $str !== '') ? $str : $default;
    }
}

if (function_exists('val')) dosf('val');
else {
    function val($value) {
        return safe($value);
    }
}