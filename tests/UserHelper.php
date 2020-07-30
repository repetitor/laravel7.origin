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

    public static function setIsRegistered($trueFalse)
    {
        self::$isRegistered = $trueFalse;
    }

    public static function setEmail()
    {
        $users = User::all();
        $prevId = count($users) ? $users->last()->id : 0;
        self::$emailDefault = 'email' . $prevId;
    }

    public static function getEmail()
    {
        return self::$emailDefault;
    }

    public static function setRequestRegister()
    {
        if (!self::$isRegistered){
            self::setEmail();
//            self::$isRegistered = true;
            self::setIsRegistered(true);
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
