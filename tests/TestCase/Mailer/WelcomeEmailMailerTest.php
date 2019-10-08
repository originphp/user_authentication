<?php
namespace UserAuthentication\Test\Mailer;

use Origin\Model\Entity;
use Origin\TestSuite\OriginTestCase;
use UserAuthentication\Mailer\WelcomeEmailMailer;

class WelcomeEmailMailerTest extends OriginTestCase
{
    public function testExecute()
    {
        $user = new Entity([], ['name' => 'User']);
        $user->first_name = 'Jim';
        $user->email = 'jim@originphp.com';

        $message = (new WelcomeEmailMailer())->dispatch($user, 123456);
        $this->assertStringContainsString('To: jim@originphp.com', $message->header());
        $this->assertStringContainsString('From: Web Application <no-reply@example.com>', $message->header());
        $this->assertStringContainsString('<p>Thank you for signing up</p>', $message->body());
        $this->assertStringContainsString('Hi Jim', $message->body());
    }
}
