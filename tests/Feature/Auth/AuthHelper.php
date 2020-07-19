<?php

namespace Tests\Feature\Auth;

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
}
