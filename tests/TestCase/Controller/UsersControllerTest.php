<?php
namespace UserAuthentication\Test\Controller;

use Origin\Security\Security;
use Origin\TestSuite\OriginTestCase;
use Origin\TestSuite\IntegrationTestTrait;

/**
 * # IMPORTANT
 * For integration testing to work you need to load the AuthComponent in the AppController and for the Plugin to be loaded
 */
/**
 * @property \App\Model\User $User
 */
class UsersControllerTest extends OriginTestCase
{
    use IntegrationTestTrait;

    protected $fixtures = ['UserAuthentication.User'];

    public function startup(): void
    {
        $this->loadModel('UserAuthentication.User');
    }

    public function testLogin()
    {
        $this->get('/login');
        $this->assertResponseOk();
        $this->assertResponseContains('<p>Login to continue</p>');
    }

    public function testLoginPost()
    {
        $this->post('/login', [
            'email' => 'jon.snow@originphp.com','password' => 123456
        ]);
        $this->assertRedirect(); // depends on config
    }

    public function testForgotPassword()
    {
        $this->get('/forgot_password');
        $this->assertResponseOk();
        $this->assertResponseContains('<p>Enter your email address and we will send you a link to reset your password.</p');
    }

    public function testForgotPasswordPost()
    {
        $this->post('/forgot_password', [
            'email' => 'jon.snow@originphp.com'
        ]);
        $this->assertResponseOk();
        $this->assertResponseContains('If the email address is found an email will be sent');
    }

    public function testChangePassword()
    {
        $uid = Security::uid();
        $this->session([
            'PasswordReset.user_id' => 1000,
            'PasswordReset.code' => $uid
        ]);
        $this->get('/change_password/' . $uid);
        $this->assertResponseOk();
        $this->assertResponseContains('<p>Enter your new password.</p>');
    }

    public function testChangePasswordInvalidCode()
    {
        $this->get('/change_password/12345678');
        $this->assertResponseNotFound();
    }

    public function testChangePasswordPost()
    {
        $uid = Security::uid();
        $this->session([
            'PasswordReset.user_id' => 1000,
            'PasswordReset.code' => $uid
        ]);
        $this->post('/change_password/' . $uid, [
            'password' => 'foo-12345'
        ]);
        $this->assertRedirect('/login');
    }

    public function testVerify()
    {
        $this->session([
            'Verification.user_id' => 1000,
            'Verification.code' => 123456
        ]);
       
        $this->get('/verify');
        $this->assertResponseOk();
        $this->assertResponseContains('<p>Enter the verification code you received in the email.</p>');
    }

    public function testVerifyPost()
    {
        $this->session([
            'Verification.user_id' => 1000,
            'Verification.code' => 123456
        ]);
       
        $this->post('/verify', [
            'code' => 123456
        ]);
        $this->assertRedirect('/login');
    }

    public function testTokenNotLoggedIn()
    {
        $this->get('/token');
        $this->assertRedirect('/login');
    }

    public function testToken()
    {
        $user = $this->User->find('first');
        $this->session([
            'Auth.User' => $user->toArray()
        ]);
        $this->get('/token');
        $this->assertResponseOk();
        $this->assertResponseContains('3905604a-b14d-4fe8-906e-7867b39289b3');
    }

    public function testTokenChange()
    {
        $user = $this->User->find('first');
        $this->session([
            'Auth.User' => $user->toArray()
        ]);
        $this->post('/token');
        $this->assertResponseOk();
        $this->assertResponseNotContains('3905604a-b14d-4fe8-906e-7867b39289b3');
        $newUser = $this->User->find('first');
        $this->assertNotEquals($newUser->token, $user->token);
        $this->assertResponseContains($newUser->token);
    }
}
