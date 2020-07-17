<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\UserHelper;

class AuthUserHelperTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        UserHelper::setIsRegistered(false);
    }

    /**
     * register
     */

    protected function doOrIgnoreDefaultRegistration()
    {
        UserHelper::setRequestRegister();

        return self::postJson(UserHelper::$uriRegister, UserHelper::$requestRegister);
    }

    public function testRegister()
    {
        // success
        $response = self::doOrIgnoreDefaultRegistration();

        $messageSuccess = 'You were successfully registered. Use your email and password to sign in.';
        $response->assertStatus(200);
        $response->assertSeeText($messageSuccess);
        $this->assertTrue(isset($response['message']));
        $this->assertTrue($response['message'] == $messageSuccess);

        /*
         * error
         */

        // email that is stored in database before
        // a)
        $response = self::doOrIgnoreDefaultRegistration();

        $response->assertStatus(500);
        $this->assertTrue(isset($response['exception']));
        $response->assertSeeText('Integrity constraint violation:');
        $response->assertSeeText('Duplicate entry');
        $response->assertSeeText('users_email_unique');

        // b)
        $user = User::first();
        UserHelper::setRequestRegister();
        UserHelper::$requestRegister['email'] = $user->email;
        $response = $this->postJson(UserHelper::$uriRegister, UserHelper::$requestRegister);

        $response->assertStatus(500);
        $this->assertTrue(isset($response['exception']));
        $response->assertSeeText('Integrity constraint violation:');
        $response->assertSeeText('Duplicate entry');
        $response->assertSeeText('users_email_unique');

        // name is empty
        UserHelper::setRequestRegister();
        UserHelper::$requestRegister['name'] = '';
        $response = $this->postJson(UserHelper::$uriRegister, UserHelper::$requestRegister);

        $response->assertStatus(422);
        $response->assertSeeText('The name field is required.');
        $this->assertTrue(isset($response['message']));
        $this->assertTrue($response['message'] == 'The given data was invalid.');
        $this->assertTrue(isset($response['errors']));
        $this->assertTrue(isset($response['errors']['name']));
        $this->assertTrue($response['errors']['name'][0] == 'The name field is required.');

        // empty email
        UserHelper::setRequestRegister();
        UserHelper::$requestRegister['email'] = '';
        $response = $this->postJson(UserHelper::$uriRegister, UserHelper::$requestRegister);

        $response->assertStatus(422);
        $response->assertSeeText('The email field is required.');
        $this->assertTrue(isset($response['message']));
        $this->assertTrue($response['message'] == 'The given data was invalid.');
        $this->assertTrue(isset($response['errors']));
        $this->assertTrue(isset($response['errors']['email']));
        $this->assertTrue($response['errors']['email'][0] == 'The email field is required.');

        // empty password
        UserHelper::setRequestRegister();
        UserHelper::$requestRegister['password'] = '';
        $response = $this->postJson(UserHelper::$uriRegister, UserHelper::$requestRegister);

        $response->assertStatus(422);
        $response->assertSeeText('The password field is required.');
        $this->assertTrue(isset($response['message']));
        $this->assertTrue($response['message'] == 'The given data was invalid.');
        $this->assertTrue(isset($response['errors']));
        $this->assertTrue(isset($response['errors']['password']));
        $this->assertTrue($response['errors']['password'][0] == 'The password field is required.');
    }

    /**
     * login
     */

    protected function doDefaultLogin()
    {
        self::doOrIgnoreDefaultRegistration();

        UserHelper::setRequestLogin();
        $response = $this->postJson(UserHelper::$uriLogin, UserHelper::$requestLogin);
        UserHelper::$tokenDefault = $response['access_token'];

        return $response;
    }

    public function testLogin()
    {
        // success
        $response = self::doDefaultLogin();

        $response->assertStatus(200);
        $response->assertSeeText('access_token');
        $this->assertTrue(isset($response['user']));
        $this->assertTrue(isset($response['access_token']));

        /*
         * Invalid login credentials
         */

        // wrong password
        UserHelper::setRequestLogin();
        UserHelper::$requestLogin['password'] = 'wrongPassword';
        $response = $this->postJson(UserHelper::$uriLogin, UserHelper::$requestLogin);

        $response->assertStatus(200);
        $this->assertTrue($response['message'] == 'Invalid login credentials.');

        // empty password
        UserHelper::setRequestLogin();
        UserHelper::$requestLogin['password'] = '';
        $response = $this->postJson(UserHelper::$uriLogin, UserHelper::$requestLogin);

        $response->assertStatus(422);
        $this->assertTrue($response['message'] == 'The given data was invalid.');
        $this->assertTrue($response['errors']['password'][0] == 'The password field is required.');
    }

    /**
     * get self user (token is required)
     */
    public function testSelfUser()
    {
        self::doDefaultLogin();
        $uri = '/api/user';

        /*
         * error
         */
        $response = $this->getJson($uri);
        $response->assertStatus(401);
        $this->assertTrue($response['message'] == 'Unauthenticated.');

        /*
         * success
         */
        $response = $this->withHeader('Authorization', 'Bearer ' . UserHelper::$tokenDefault)
            ->getJson($uri);
        $response->assertStatus(200);
        $this->assertTrue($response['name'] == UserHelper::$nameDefault);
        $this->assertTrue($response['email'] == UserHelper::getEmail());
    }

    /**
     * logout (token is required)
     */
    public function testLogout()
    {
        $uri = '/api/logout';
        self::doDefaultLogin();

        /*
         * error
         */

        // without token
        $response = $this->postJson($uri);
        $response->assertStatus(401);
        $this->assertTrue($response['message'] == 'Unauthenticated.');

        // wrong token
        $response = $this->withHeader('Authorization', 'Bearer wrongToken')->postJson($uri);
        $response->assertStatus(401);
        $this->assertTrue($response['message'] == 'Unauthenticated.');

        /*
         * success - correct token
         */
        $response = $this->withHeader('Authorization', 'Bearer ' . UserHelper::$tokenDefault)
            ->postJson($uri);
        $response->assertStatus(200);
        $this->assertTrue($response['message'] == 'You are successfully logged out');
    }
}
