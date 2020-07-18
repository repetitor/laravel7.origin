<?php

namespace Tests\Feature\Auth;

//use Illuminate\Support\Facades\Http;

use Illuminate\Support\Facades\Http;

class AuthHelper
{
    const URI_REGISTER = '/api/register';
    const URI_LOGIN = '/api/login';
    const URI_LOGOUT = '/api/logout';

    const NAME = 'name';
    const EMAIL = 'email';
    const PASSWORD = 'password';

    const REQUEST_REGISTER = [
        'name' => self::NAME,
        'email' => self::EMAIL,
        'password' => self::PASSWORD,
    ];

    const REQUEST_LOGIN = [
        'email' => self::EMAIL,
        'password' => self::PASSWORD,
    ];

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

    static public $name = 'name';
    static public $email = 'email';
    static public $password = 'password';

    private static function register()
    {
//        Http::post('http://localhost:92/api/register', [
        Http::post(env('APP_URL') . '/api/register', [
            'name' => 'Taylor12',
            'email' => 'Developeraa',
            'password' => 'Developer',
        ]);
    }

    public static function getLoginRequest()
    {
        self::register();
    }
}
