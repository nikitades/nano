<?php

namespace app\system;

class View
{

    const PHP_PREFIX = '<?PHP
        use app\system\Flash;
        use app\models\User;
    ?>';

    public static $variables = [];

    private $content;
    private $name;
    private $data;

    public static function path($name)
    {
        $original_path = '../resources/views/' . str_replace('.', '/', $name) . PHP_EXT;
        $compiled_path = '../stash/compiled/views/' . md5($name) . PHP_EXT;
        if (!file_exists($compiled_path) || !self::verify($original_path, $compiled_path)) {
            self::compile($original_path, $compiled_path);
        }
        return $compiled_path;
    }

    private static function compile($original_path, $compiled_path)
    {
        return file_put_contents($compiled_path, self::PHP_PREFIX . file_get_contents($original_path));
    }

    private static function decompile($compiled_path)
    {
        return substr(file_get_contents($compiled_path), strlen(self::PHP_PREFIX));
    }

    private static function verify($original_path, $compiled_path)
    {
        return file_get_contents($original_path) === self::decompile($compiled_path);
    }

    public function __construct($name, Array $data = [])
    {
        $this->name = $name;
        $this->data = $data;
        $this->fill();
    }

    private function fill()
    {
        self::$variables = array_merge(self::$variables, $this->data);
        extract(self::$variables, EXTR_OVERWRITE);
        ob_start();
        require View::path($this->name);
        $this->content = ob_get_clean();
    }

    public function appear()
    {
        print $this->content;
        return true;
    }
}