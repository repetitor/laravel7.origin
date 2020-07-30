<?php

namespace Tests\Feature\Auth;

class AuthHelper
{
    const URI_REGISTER = '/api/register';
    const URI_LOGIN = '/api/login';
    const URI_SELFUSER = '/api/user';
    const URI_LOGOUT = '/api/logout';

    const NAME = 'name';
    const EMAIL = 'email';
//    const PASSWORD = \UserSeeder::PASSWORD;

    const REQUEST_REGISTER = [
        'name' => self::NAME,
        'email' => self::EMAIL,
        'password' => \UserSeeder::PASSWORD,
    ];

    const REQUEST_LOGIN = [
        'email' => self::EMAIL,
        'password' => \UserSeeder::PASSWORD,
    ];

    public static function getToken($email, $requester)
    {
        $request = self::REQUEST_LOGIN;
        $request['email'] = $email;
        $response = $requester->postJson(self::URI_LOGIN, $request);

        return $response['access_token'];
    }
}
