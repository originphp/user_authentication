<?php
namespace UserAuthentication\Test\Mailer;

use Origin\Core\Config;
use Origin\Model\Entity;
use Origin\TestSuite\OriginTestCase;
use UserAuthentication\Mailer\EmailVerificationMailer;

class EmailVerificationMailerTest extends OriginTestCase
{
    public function testExecute()
    {
        $user = new Entity(['name' => 'User']);
        $user->first_name = 'Jim';
        $user->email = 'jim@originphp.com';
        $url = Config::read('App.url');

        $message = (new EmailVerificationMailer())->dispatch($user, 123456);
        $this->assertStringContainsString('To: jim@originphp.com', $message->header());
        $this->assertStringContainsString('From: Web Application <no-reply@example.com>', $message->header());
        $this->assertStringContainsString('<a href="'.$url.'/verify">', $message->body());
        $this->assertStringContainsString('123456', $message->body());
    }
}
