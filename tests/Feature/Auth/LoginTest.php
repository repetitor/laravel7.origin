<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
//    use RefreshDatabase;

    protected static $isUserRegistered = false;

    public function setUp(): void
    {
        parent::setUp();

        if (!static::$isUserRegistered) {
            $this->postJson(AuthHelper::URI_REGISTER, AuthHelper::REQUEST_REGISTER);
            static::$isUserRegistered = true;
        }
    }

    public function tearDown(): void
    {
        parent::refresh();
    }

    public function test_success()
    {
        $request = AuthHelper::REQUEST_LOGIN;
        $response = $this->postJson(AuthHelper::URI_LOGIN, $request);

        $response->assertStatus(200);
        $response->assertSeeText('access_token');
        $this->assertTrue(isset($response['user']));
        $this->assertTrue(isset($response['access_token']));
    }

    public function test_error_wrong_password()
    {
        $request = AuthHelper::REQUEST_LOGIN;
        $request['password'] = 'wrongPassword';
        $response = $this->postJson(AuthHelper::URI_LOGIN, $request);

        $response->assertStatus(200);
        $this->assertTrue($response['message'] == 'Invalid login credentials.');
    }

    public function test_error_empty_password()
    {
        $request = AuthHelper::REQUEST_LOGIN;
        $request['password'] = '';
        $response = $this->postJson(AuthHelper::URI_LOGIN, $request);

        $response->assertStatus(422);
        $this->assertTrue($response['message'] == 'The given data was invalid.');
        $this->assertTrue($response['errors']['password'][0] == 'The password field is required.');
    }

    public function test_error_absent_password()
    {
        $request = AuthHelper::REQUEST_LOGIN;
        unset($request['password']);
        $response = $this->postJson(AuthHelper::URI_LOGIN, $request);

        $response->assertStatus(422);
        $this->assertTrue($response['message'] == 'The given data was invalid.');
        $this->assertTrue($response['errors']['password'][0] == 'The password field is required.');
    }
}
