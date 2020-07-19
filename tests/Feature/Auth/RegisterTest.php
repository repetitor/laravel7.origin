<?php

namespace Tests\Feature\Auth;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Tests\TestCase;
use Tests\UserHelper;

class RegisterTest extends TestCase
{
//    use RefreshDatabase;

//    public function setUp(): void
//    {
//        parent::setUp();
//    }

    public function tearDown(): void
    {
//        parent::tearDown(); -> problem: Target class [env] does not exist.
        parent::refresh();
    }

    protected function isAssertSuccess($response)
    {
        $response->assertStatus(200);
        $messageSuccess = 'You were successfully registered. Use your email and password to sign in.';
        $response->assertSeeText($messageSuccess);
        $this->assertTrue(isset($response['message']));
        $this->assertTrue($response['message'] == $messageSuccess);
    }

    protected function isAssertError($response)
    {
        $response->assertStatus(422);
        $response->assertSeeText('is required.');
        $this->assertTrue(isset($response['message']));
        $this->assertTrue($response['message'] == 'The given data was invalid.');
        $this->assertTrue(isset($response['errors']));
    }

    protected function isAssertEmptyName($response)
    {
        $response->assertStatus(422);
        $response->assertSeeText('The name field is required.');
        $this->assertTrue(isset($response['message']));
        $this->assertTrue($response['message'] == 'The given data was invalid.');
        $this->assertTrue(isset($response['errors']));
        $this->assertTrue(isset($response['errors']['name']));
        $this->assertTrue($response['errors']['name'][0] == 'The name field is required.');
    }

    public function test_success()
    {
        $request = AuthHelper::REQUEST_REGISTER;
        $response = $this->postJson(AuthHelper::URI_REGISTER, $request);

//        $response->assertStatus(200);
//        $messageSuccess = 'You were successfully registered. Use your email and password to sign in.';
//        $response->assertSeeText($messageSuccess);
//        $this->assertTrue(isset($response['message']));
//        $this->assertTrue($response['message'] == $messageSuccess);
        $this->isAssertSuccess($response);
    }

    public function test_success_name()
    {
        $request = AuthHelper::REQUEST_REGISTER;
        $request['name'] = 'also normal name';
        $response = $this->postJson(AuthHelper::URI_REGISTER, $request);

        $this->isAssertSuccess($response);
    }

    public function test_success_max_length_name()
    {
        $request = AuthHelper::REQUEST_REGISTER;
        $request['name'] = Str::random(255);
        $response = $this->postJson(AuthHelper::URI_REGISTER, $request);

        $this->isAssertSuccess($response);
    }

    public function test_success_email()
    {
        $request = AuthHelper::REQUEST_REGISTER;
        $request['email'] = 'also normal email';
        $response = $this->postJson(AuthHelper::URI_REGISTER, $request);

        $this->isAssertSuccess($response);
    }

    public function test_success_password()
    {
        $request = AuthHelper::REQUEST_REGISTER;
        $request['password'] = 'p';
        $response = $this->postJson(AuthHelper::URI_REGISTER, $request);

        $this->isAssertSuccess($response);
    }

    public function test_error_empty_name()
    {
        $request = AuthHelper::REQUEST_REGISTER;
        $request['name'] = '';
        $response = $this->postJson(AuthHelper::URI_REGISTER, $request);

        $this->isAssertEmptyName($response);
    }

    public function test_error_absent_name()
    {
        $request = AuthHelper::REQUEST_REGISTER;
        unset($request['name']);
        $response = $this->postJson(AuthHelper::URI_REGISTER, $request);

        $this->isAssertEmptyName($response);
    }

    public function test_error_loo_long_name()
    {
        $request = AuthHelper::REQUEST_REGISTER;
        $request['name'] = Str::random(256);
        $response = $this->postJson(AuthHelper::URI_REGISTER, $request);

        $response->assertStatus(500);
        $this->assertTrue(isset($response['exception']));
        $this->assertTrue($response['exception'] == 'Illuminate\\Database\\QueryException');
        $response->assertSeeText('Data too long for column');
    }

    public function test_error_duplicate_email()
    {
        $request = AuthHelper::REQUEST_REGISTER;

        // a)
        $this->post(AuthHelper::URI_REGISTER, $request);

        // b)
//        $user = User::first();
//        if(!$user){
////            Artisan::call('db:seed', ['--class' => 'DatabaseSeeder']);
//            Artisan::call('db:seed', ['--class' => 'UserSeeder']);
//            $user = User::first();
//        }
//        $request['email'] = $user->email;

        $response = $this->postJson(AuthHelper::URI_REGISTER, $request);

        $response->assertStatus(500);
        $this->assertTrue(isset($response['exception']));
        $response->assertSeeText('Integrity constraint violation:');
        $response->assertSeeText('Duplicate entry');
        $response->assertSeeText('users_email_unique');
    }

    public function test_error_empty_email()
    {
        $request = AuthHelper::REQUEST_REGISTER;
        $request['email'] = '';
        $response = $this->postJson(AuthHelper::URI_REGISTER, $request);

        $this->isAssertError($response);
        $this->assertTrue($response['errors']['email'][0] == 'The email field is required.');
    }

    public function test_error_absent_email()
    {
        $request = AuthHelper::REQUEST_REGISTER;
        unset($request['email']);
        $response = $this->postJson(AuthHelper::URI_REGISTER, $request);

        $this->isAssertError($response);
        $this->assertTrue($response['errors']['email'][0] == 'The email field is required.');
    }

    public function test_error_empty_password()
    {
        $request = AuthHelper::REQUEST_REGISTER;
        $request['password'] = '';
        $response = $this->postJson(AuthHelper::URI_REGISTER, $request);

        $this->isAssertError($response);
        $this->assertTrue($response['errors']['password'][0] == 'The password field is required.');
    }

    public function test_error_absent_password()
    {
        $request = AuthHelper::REQUEST_REGISTER;
        unset($request['password']);
        $response = $this->postJson(AuthHelper::URI_REGISTER, $request);

        $this->isAssertError($response);
        $this->assertTrue($response['errors']['password'][0] == 'The password field is required.');
    }
}
