<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use Tests\UserHelper;

class Auth2Test extends TestCase
{
    /**
     * If true, setup has run at least once.
     *
     * @var bool
     */
    protected static $setUpHasRunOnce = false;

    /**
     * After the first run of setUp "migrate:fresh --seed".
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
//        $this->artisan('migrate:fresh');
//        $this->artisan('passport:install');
//        $this->artisan('db:seed --class=UsersTableSeeder');

        if (!static::$setUpHasRunOnce) {
            Artisan::call('migrate:fresh');
            Artisan::call('passport:install');
//            Artisan::call(
//                'db:seed',
//                // ['--class' => 'UsersTableSeeder']
//            );
            static::$setUpHasRunOnce = true;
        }
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
        $response = self::doOrIgnoreDefaultRegistration();

        $response->assertStatus(500);
        $this->assertTrue(isset($response['exception']));
        $response->assertSeeText('Integrity constraint violation:');

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
        $this->assertTrue($response['id'] == '1');
        // $this->assertTrue($response['id'] == '1.'); // ??? 1.
        $this->assertFalse($response['id'] == '2');
        $this->assertTrue($response['name'] == UserHelper::$nameDefault);
        $this->assertTrue($response['email'] == UserHelper::$emailDefault);
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
