<?php

namespace app\controllers;

use app\models\User;
use app\system\nucleus\Validator;
use app\system\Request;

class AuthController
{
    public function showLogin()
    {
        return view('pages.login');
    }

    public function showRegister()
    {
        return view('pages.register');
    }

    public function login()
    {
        $data = Request::fetch('email:ne', 'password:ne', 'remember');
        if (!Validator::ok()) {
            back([
                'flash' => Validator::$errors,
                'form_data' => $data
            ]);
        } else {
            if (!sizeof($users = User::where('email', $data['email'])))
                back([
                    'flash' => [
                        'danger::Пользователь с такими данными не найден!'
                    ],
                    'form_data' => $data
                ]);
            $user = array_shift($users);
            if (!$user->validate($data['password'])) {
                back([
                    'flash' => [
                        'danger::Логин или пароль не подходят!'
                    ],
                    'form_data' => $data
                ]);
            } else {
                $user->fillSession();
                go('/');
            }
        }
    }

    public function logout()
    {
        User::destroyAuth();
        back(null, '/');
    }

    public function register()
    {
        $data = Request::fetch('name:ne', 'password:len@8', 'email:email');
        if (!Validator::ok()) {
            back([
                'flash' => Validator::$errors,
                'form_data' => $data
            ]);
        }
        $user = new User();
        $user->fromArray($data);
        $user->register();
        go('/login', [
            'flash' => [
                'success::Регистрация успешна'
            ]
        ]);
    }
}