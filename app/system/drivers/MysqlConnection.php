<?php

namespace app\system\drivers;

use app\system\exceptions\NanoException;
use app\system\nucleus\DBConnection;
use Exception;
use PDO;

class MysqlConnection implements DBConnection
{
    private $host;
    private $db_name;
    private $user;
    private $password;
    private $options;

    private $link;

    public function __construct(Array $params)
    {
        try {
            $this->host = $params['db_host'];
            $this->db_name = $params['db_name'];
            $this->user = $params['db_user'];
            $this->password = $params['db_password'];
            $this->options = $params['options'];
            $this->establish();
            if (!$this->check()) throw new NanoException('Error while initializing the DB!');
            $this->link->exec("set names utf8");
        } catch (NanoException $e) {
            dd($e->getMessage());
        }
    }

    public function establish()
    {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->db_name}";
            $this->link = new PDO($dsn, $this->user, $this->password, $this->options);
            if (!$this->check()) throw new NanoException('The DB connection was not established!');
            return true;
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    function check()
    {
        return is_object($this->link) && get_class($this->link) == 'PDO';
    }

    function query($query, $arguments)
    {
        try {
            $bound = [];
            $statement = $this->link->prepare($query);
            self::makeArgs($arguments, $bound);
            $statement->execute($bound);
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    function select(Array $params)
    {
        try {
            $bound = [];
            $query = "SELECT {$params['fields']} FROM {$params['table']}" . (!empty($params['where']) ? " WHERE " . self::makeWhere($params['where'], $bound) : '');
            $statement = $this->link->prepare($query);
            $statement->execute($bound);
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    function update(Array $params, $arguments = [])
    {
        try {
            $bound = [];
            $query = "UPDATE {$params['table']} SET " . self::makeUpdate($params['values'], $bound) . (!empty($params['where']) ? " WHERE " . self::makeWhere($params['where'], $bound) : '');
            $statement = $this->link->prepare($query);
            $statement->execute($bound);
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    function insert(Array $params, $arguments = [])
    {
        try {
            $bound = [];
            $keys = self::makeKeys($params['values']);
            $values = self::makeValues($params['values'], $bound);
            $query = "INSERT INTO {$params['table']} ({$keys}) VALUES ({$values})";
            $statement = $this->link->prepare($query);
            $statement->execute($bound);
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    function delete(Array $params)
    {
        try {
            $query = "DELETE FROM {$params['table']} WHERE " . self::makeWhere($params['where']);
            $statement = $this->link->prepare($query);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    function id()
    {
        try {
            return $this->link->lastInsertID();
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    /*---------------------------------*/
    /* Make-functions below
    /*---------------------------------*/

    public static function makeArgs(Array $args, &$bound)
    {
        foreach ($args as $key => $value) {
            $bound[':' . $key] = $value;
        }
    }

    public static function makeWhere(Array $where, &$bound)
    {
        $str = [];
        foreach ($where as $key => $value) {
            $bound[":{$key}"] = $value;
            $str[] = "`{$key}` " . (is_array($value) ? implode(' ', ":{$key}") : "= :{$key}");
        }
        return implode(' AND ', $str);
    }

    public static function makeUpdate(Array $update, &$bound)
    {
        $str = [];
        foreach ($update as $key => $value) {
            $bound[":{$key}"] = $value;
            $str[] = "`{$key}` = :{$key}";
        }
        return implode(', ', $str);
    }

    public static function makeKeys(Array $values)
    {
        $keys = [];
        foreach ($values as $key => $value) $keys[] = "`{$key}`";
        return implode(', ', $keys);
    }

    public static function makeValues(Array $values, &$bound)
    {
        $o_values = [];
        foreach ($values as $key => $value) {
            $bound[":{$key}"] = $value;
            $o_values[] = ":{$key}";
        }
        return implode(', ', $o_values);
    }
}