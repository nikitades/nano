<?php

namespace app\system;

use app\system\drivers\MysqlConnection;
use app\system\exceptions\NanoException;

class DB
{
    public static $neuron;

    public static function __callStatic($method, $arguments)
    {
        try {
            reg('db_used', true);
            switch ($method) {
                case 'q':
                    if (sizeof($arguments < 2)) throw new NanoException('Wrong arguments amount given!');
                    return self::$neuron->query($arguments[0], $arguments[1]);
                    break;
                case 'select':
                case 'insert':
                case 'update':
                case 'delete':
                    return self::$neuron->$method(array_shift($arguments));
                    break;
                case 'id':
                    return self::$neuron->$method();
                    break;
            }
        } catch (NanoException $e) {
            dd($e->getMessage());
        }
    }

    public static function init()
    {
        try {
            switch (dpl('db_driver')) {
                case 'mysql':
                    self::$neuron = new MysqlConnection([
                        'db_host' => dpl('db_host'),
                        'db_name' => dpl('db_name'),
                        'db_user' => dpl('db_user'),
                        'db_password' => dpl('db_password'),
                        'options' => []
                    ]);
                    break;
                default:
                    throw new NanoException('The DB driver was not found!');
            }
        } catch (NanoException $e) {
            dd($e->getMessage());
        }
    }
}