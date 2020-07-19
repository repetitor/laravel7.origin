<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SelfUserTest extends TestCase
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
            ->getJson(AuthHelper::URI_SELFUSER);

        $response->assertStatus(200);
        $this->assertTrue($response['name'] == AuthHelper::NAME);
        $this->assertTrue($response['email'] == AuthHelper::EMAIL);
    }

    public function test_error_without_token()
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . static::$token . 'wrong')
            ->getJson(AuthHelper::URI_SELFUSER);

        $response->assertStatus(401);
        $this->assertTrue($response['message'] == 'Unauthenticated.');
    }

    public function test_error_wrong_token()
    {
        $response = $this->getJson(AuthHelper::URI_SELFUSER);

        $response->assertStatus(401);
        $this->assertTrue($response['message'] == 'Unauthenticated.');
    }
}
