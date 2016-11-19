<?php

namespace app\system;

use app\system\exceptions\NanoException;

class System
{

    private $end = false;
    private $checkEnding = true;
    public static $request;
    public static $register;

    public function __construct()
    {
        $this->checkEnding();
        self::$request = new Request();
        self::$request->fill();
        self::$request->check();
        session_start();
    }

    public function run()
    {
        $this->init();
        $this->end = true;
    }

    private function runController()
    {
        if (is_object(self::$request->function)) {
            $f = self::$request->function;
            return $f();
        } else {
            if (!namespaced(self::$request->controller)) return Request::error404();
            if (!method_exists(self::$request->controller, self::$request->function)) return Request::error404();
            return call_user_func_array([self::$request->controller, self::$request->function], self::$request->arguments);
        }
    }

    private function checkEnding()
    {
        $this->checkEnding = dpl('CHECK_ENDING');
    }

    public function __destruct()
    {
        try {
            if ($this->checkEnding && !$this->end) throw new NanoException('Incorrect system deconstruction!');
        } catch (NanoException $e) {
            dd($e->getMessage());
        }
    }

    public function init()
    {
        DB::init();
        response($this->runController());
    }
}