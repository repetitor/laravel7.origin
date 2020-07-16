<?php

namespace Tests;

use App\User;

class UserHelper
{
    static protected $isRegistered = false;

    static public $nameDefault = 'name';
    static public $emailDefault = 'will be changed';
    static public $passwordDefault = 'password';
    static public $tokenDefault = null;

    static public $uriRegister = '/api/register';
    static public $uriLogin = '/api/login';

    static public $requestRegister;
    static public $requestLogin;

    public function __construct()
    {
        self::$emailDefault = 'email' . (User::all()->last()->id + 1);
    }

    public static function setEmail()
    {
        self::$emailDefault = 'email' . (User::all()->last()->id + 1);
    }

    public static function getEmail()
    {
        return self::$emailDefault;
    }

    public static function setRequestRegister()
    {
        if (!self::$isRegistered){
            self::setEmail();
            self::$isRegistered = true;
        }

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
