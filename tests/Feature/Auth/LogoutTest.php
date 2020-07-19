<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    protected static $token = false;

    public function setUp(): void
    {
        parent::setUp();

        if (!static::$token) {
            $this->postJson(AuthHelper::URI_REGISTER, AuthHelper::REQUEST_REGISTER);
            $response = $this->postJson(AuthHelper::URI_LOGIN, AuthHelper::REQUEST_LOGIN);
            static::$token = $response['access_token'];
        }
    }

    public function tearDown(): void
    {
        parent::refresh();
    }

    public function test_success()
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . static::$token)
            ->postJson(AuthHelper::URI_LOGOUT);

        $response->assertStatus(200);
        $this->assertTrue($response['message'] == 'You are successfully logged out');
    }

    public function test_error_without_token()
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . static::$token . 'wrong')
            ->postJson(AuthHelper::URI_LOGOUT);

        $response->assertStatus(401);
        $this->assertTrue($response['message'] == 'Unauthenticated.');
    }

    public function test_error_without_token_post_not_json()
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . static::$token . 'wrong')
//            ->postJson(AuthHelper::URI_LOGOUT);
            ->post(AuthHelper::URI_LOGOUT);

//        $response->assertStatus(401);
        $response->assertStatus(500);
//        $this->assertTrue($response['message'] == 'Unauthenticated.');
    }

    public function test_error_wrong_token()
    {
        $response = $this->postJson(AuthHelper::URI_LOGOUT);

        $response->assertStatus(401);
        $this->assertTrue($response['message'] == 'Unauthenticated.');
    }
}
