<?php

namespace app\models;

use app\system\nucleus\Model;

class User extends Model
{
    protected $table = 'users';
    protected $writable = [
        'name',
        'hash',
        'email',
        'post_count',
        'comments_count'
    ];

    public $name;
    protected $hash;
    protected $password;
    public $email;

    public function register()
    {
        foreach ([
                     $this->name,
                     $this->password,
                     $this->email
                 ] as $field) {
            if (empty($field)) return false;
        }
        $this->hash = password_hash(dpl('salt') . $this->password, PASSWORD_BCRYPT, ['cost' => 12]);
        return $this->save();
    }

    public function validate($password)
    {
        return password_verify(dpl('salt') . $password, $this->hash);
    }

    public function fillSession()
    {
        //TODO: implement the user remembering feature via the cookie session code.
        $_SESSION['user'] = $this;
    }

    public static function checkAuth()
    {
        return isset($_SESSION['user']);
    }

    public static function current()
    {
        return self::checkAuth() ? $_SESSION['user'] : false;
    }

    public static function destroyAuth()
    {
        unset($_SESSION['user']);
    }
}