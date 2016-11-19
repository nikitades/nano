<?php

namespace app\system\nucleus;

class Validator
{

    public static $errors;

    public static function check($key, $input, $validation = 'any')
    {
        $ok = true;
        $validation = explode(':', $validation);
        foreach ($validation as $rule) {
            $rule = explode('@', $rule);
            $method = array_shift($rule);
            array_unshift($rule, $input);
            array_unshift($rule, $key);
            if (method_exists(get_class(), $method)) {
                $result = call_user_func_array([get_class(), $method], $rule);
                $ok = $ok == false ? $ok : $result;
            }
        }
        return $ok;
    }

    public static function ok()
    {
        return !isset(self::$errors) || empty(self::$errors);
    }

    private static function error($text)
    {
        self::$errors[] = "danger::" . $text;
        return false;
    }

    public static function any()
    {
        return true;
    }

    /* Not empty */
    public static function ne($field, $input)
    {
        return isset($input) && is_string($input) && $input !== '' ? true : self::error("The field \"{$field}\" should not be empty!");
    }

    public static function email($field, $input)
    {
        return preg_match('/(.+)@(.+)\.(.+)/', $input) ? true : self::error("The field \"{$field}\" should be of type \"E-mail\"!");
    }

    public static function string($field, $input)
    {
        return is_string($input) ? true : self::error("The field \"{$field}\" contains not a string!");
    }

    public static function len($field, $input, $length)
    {
        return is_string($input) && strlen($input) >= $length ? true : self::error("The field \"{$field}\" is less than {$length} symbols length!");
    }
}