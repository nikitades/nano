<?php

namespace app\system\nucleus;

use app\system\DB;
use PDO;

class Model
{
    const WRITABLE_ONLY = true;

    protected $table = 'test';
    protected $writable = [];

    public static function id($id)
    {
        $item = new static();
        $q = DB::select([
            'fields' => '*',
            'table' => $item->table,
            'where' => [
                'id' => $id
            ]
        ]);
        if (sizeof($q)) {
            $selected = array_shift($q);
            $item->fromArray($selected);
            return $item;
        }
        return false;
    }

    public static function all()
    {
        $output = [];
        $q = DB::select([
            'fields' => '*',
            'table' => (new static())->table
        ]);
        foreach ($q as $row) {
            $item = new static();
            $item->fromArray($row);
            $output[] = $item;
        }
        return $output;
    }

    public static function where($field, $value)
    {
        $item = new static();
        $q = DB::select([
            'fields' => '*',
            'table' => $item->table,
            'where' => [
                $field => $value
            ]
        ]);
        $items = [];
        if (sizeof($q)) {
            foreach ($q as $item) {
                $instance = new static();
                $instance->fromArray($item);
                $items[] = $instance;
            }
        }
        return $items;
    }

    public function save()
    {
        $values = $this->toArray(self::WRITABLE_ONLY);
        if (empty($this->id)) {
            $res = DB::insert([
                'table' => $this->table,
                'values' => $values
            ]);
        } else {
            $res = DB::update([
                'table' => $this->table,
                'values' => $values,
                'where' => [
                    'id' => $this->id
                ]
            ]);
        }
        $item = static::id(DB::id());
        $this->fromArray($item->toArray());
        return (is_array($res) && empty($res)) ? $this : false;
    }

    public function update(Array $values)
    {
        $res = DB::update([
            'table' => $this->table,
            'values' => array_filter($values, function ($value, $key) {
                return in_array($key, $this->writable);
            }, ARRAY_FILTER_USE_BOTH),
            'where' => [
                'id' => $this->id
            ]
        ]);
        $item = static::id($this->id);
        $this->fromArray($item->toArray());
        return (is_array($res) && empty($res)) ? $this : false;
    }

    public function delete()
    {
        $res = DB::delete([
            'table' => $this->table,
            'where' => [
                'id' => $this->id
            ]
        ]);
        return (is_array($res) && empty($res)) ? true : false;
    }

    public function toArray($writable_only = false)
    {
        $output = [];
        $properties = [];
        foreach ($this as $field => $val) {
            if (!$writable_only || ($writable_only && in_array($field, $this->writable))) $properties[$field] = $val;
        }
        foreach ($properties as $field => $val) $output[$field] = $val;
        return $output;
    }

    public function fromArray($array)
    {
        foreach ($array as $field => $val) {
            $this->$field = $val;
        }
    }
}