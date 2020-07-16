<?php

namespace Tests;

class UserHelper
{
    static public $nameDefault = 'name';
    static public $emailDefault = 'email';
    static public $passwordDefault = 'password';
    static public $tokenDefault = null;

    static public $uriRegister = '/api/register';
    static public $uriLogin = '/api/login';

    static public $requestRegister;
    static public $requestLogin;

    public static function setRequestRegister()
    {
        $requestJson = '{
            "name": "' . self::$nameDefault . '",
            "email": "' . self::$emailDefault . '",
            "password": "' . self::$passwordDefault . '"
        }';

        self::$requestRegister = json_decode($requestJson, true);
    }

    public static function setRequestLogin()
    {
        $requestJson = '{
            "email": "' . self::$emailDefault . '",
            "password": "' . self::$passwordDefault . '"
        }';

        self::$requestLogin = json_decode($requestJson, true);
    }
}
