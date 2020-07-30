<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    static protected $nameDefault = 'name';
    static protected $emailDefault = 'email.auth.test';
    static protected $passwordDefault = 'password';
    static protected $tokenDefault = null;

    static protected $uriRegister = '/api/register';
    static protected $uriLogin = '/api/login';

    static protected $requestRegister;
    static protected $requestLogin;

    /**
     * register
     */

    protected function setRequestRegister()
    {
        $requestJson = '{
            "name": "' . self::$nameDefault . '",
            "email": "' . self::$emailDefault . '",
            "password": "' . self::$passwordDefault . '"
        }';

        self::$requestRegister = json_decode($requestJson, true);
    }

    protected function doOrIgnoreDefaultRegistration()
    {
        self::setRequestRegister();

        return self::postJson(self::$uriRegister, self::$requestRegister);
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
        $response = self::doOrIgnoreDefaultRegistration();

        $response->assertStatus(500);
        $this->assertTrue(isset($response['exception']));
        $response->assertSeeText('Integrity constraint violation:');

        // name is empty
        self::setRequestRegister();
        self::$requestRegister['name'] = '';
        $response = $this->postJson(self::$uriRegister, self::$requestRegister);

        $response->assertStatus(422);
        $response->assertSeeText('The name field is required.');
        $this->assertTrue(isset($response['message']));
        $this->assertTrue($response['message'] == 'The given data was invalid.');
        $this->assertTrue(isset($response['errors']));
        $this->assertTrue(isset($response['errors']['name']));
        $this->assertTrue($response['errors']['name'][0] == 'The name field is required.');

        // empty email
        self::setRequestRegister();
        self::$requestRegister['email'] = '';
        $response = $this->postJson(self::$uriRegister, self::$requestRegister);

        $response->assertStatus(422);
        $response->assertSeeText('The email field is required.');
        $this->assertTrue(isset($response['message']));
        $this->assertTrue($response['message'] == 'The given data was invalid.');
        $this->assertTrue(isset($response['errors']));
        $this->assertTrue(isset($response['errors']['email']));
        $this->assertTrue($response['errors']['email'][0] == 'The email field is required.');

        // empty password
        self::setRequestRegister();
        self::$requestRegister['password'] = '';
        $response = $this->postJson(self::$uriRegister, self::$requestRegister);

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

    protected function setRequestLogin()
    {
        $requestJson = '{
            "email": "' . self::$emailDefault . '",
            "password": "' . self::$passwordDefault . '"
        }';

        self::$requestLogin = json_decode($requestJson, true);
    }

    protected function doDefaultLogin()
    {
        self::doOrIgnoreDefaultRegistration();

        self::setRequestLogin();
        $response = $this->postJson(self::$uriLogin, self::$requestLogin);
        self::$tokenDefault = $response['access_token'];

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
        self::setRequestLogin();
        self::$requestLogin['password'] = 'wrongPassword';
        $response = $this->postJson(self::$uriLogin, self::$requestLogin);

        $response->assertStatus(200);
        $this->assertTrue($response['message'] == 'Invalid login credentials.');

        // empty password
        self::setRequestLogin();
        self::$requestLogin['password'] = '';
        $response = $this->postJson(self::$uriLogin, self::$requestLogin);

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
        $response = $this->withHeader('Authorization', 'Bearer ' . self::$tokenDefault)->getJson($uri);
        $response->assertStatus(200);
        $this->assertFalse($response['id'] == '2');
        $this->assertTrue($response['name'] == self::$nameDefault);
        $this->assertTrue($response['email'] == self::$emailDefault);
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
        $response = $this->withHeader('Authorization', 'Bearer ' . self::$tokenDefault)->postJson($uri);
        $response->assertStatus(200);
        $this->assertTrue($response['message'] == 'You are successfully logged out');
    }
}
