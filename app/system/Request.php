<?php

namespace app\system;

use app\system\nucleus\Validator;

class Request
{

    public $parameters;
    public $controller;
    public $function;
    public $arguments;
    public $paths;
    private $method;
    private $is404 = false;
    private $ended = false;

    public function __construct()
    {
        $this->parameters = $_REQUEST;
        $this->path = $_SERVER['REQUEST_URI'];
        $this->method = $_SERVER['REQUEST_METHOD'];
    }

    public function fill()
    {
        Path::track('/nano', function () {
            nanolink('pages.cat');
        });
        require_once '../app/pathfinder.php';
    }

    public function check()
    {
        self::prepareQuery($this->path);
        foreach ($this->paths[$this->method] as $path => $handler) {
            self::prepareQuery($path);
            if (($arguments = self::comparePath($path, $this->path)) !== false) {
                if (is_object($handler)) {
                    $this->function = $handler;
                    $this->controller = false;
                    $this->arguments = false;
                } else {
                    list($this->controller, $this->function) = explode('@', $handler);
                    $this->arguments = $arguments;
                }
                $this->becomeEnded();
                return true;
            }
        }
        $this->become404();
    }

    public function become404()
    {
        $this->is404 = true;
    }

    public function becomeEnded()
    {
        $this->ended = true;
    }

    /* Static functions */

    /**
     * A boolean function to find out whether two paths are equal or not.
     *
     * @param array $app_path
     * @param array $source_path
     * @return bool
     */
    public static function comparePath($app_path, $source_path)
    {
        $variables_list = [];
        if ($app_path == '/' && $app_path == $source_path) {
            return $variables_list;
        }
        list($app_path, $source_path) = [explode('/', $app_path), explode('/', $source_path)];
        if (sizeof($app_path) != sizeof($source_path)) return false;
        foreach ($app_path as $index => $app_path_item) {
            if (self::checkIfIsVariable($app_path_item)) {
                $variables_list[$app_path_item] = $source_path[$index];
            } else {
                if ($app_path_item != $source_path[$index]) return false;
            }
        }
        return $variables_list;
    }

    public static function checkIfIsVariable($path_item)
    {
        return (substr($path_item, 0, 1) == '#' && substr($path_item, -1) == '#');
    }

    public static function prepareQuery(&$query)
    {
        $query = trim($query);
        if ($query != '' && $query != '/') {
            if ($query[0] == '/') $query = substr($query, 1);
            if ($query[strlen($query) - 1] == '/') $query = substr($query, 0, -1);
        }
    }

    /* Data functions */

    public static function fetch()
    {
        return self::validate($_REQUEST, func_get_args());
    }

    private static function validate(Array $input, $rules)
    {
        $filtered_input = [];
        if (empty($rules)) return $input;
        foreach ($rules as $rule) {
            $item_exploded = explode(':', $rule, 2);
            $key = $item_exploded[0];
            $validation = isset($item_exploded[1]) ? $item_exploded[1] : 'any';
            $value = isset($input[$key]) ? $input[$key] : false;
            if ($value !== false && Validator::check($key, $value, $validation)) $filtered_input[$key] = $value;
        }
        return $filtered_input;
    }

    /* Answer functions */

    public static function error404()
    {
        header($_SERVER['SERVER_PROTOCOL'] . " 404 Not Found", true);
        return view('pages.error404');
    }
}