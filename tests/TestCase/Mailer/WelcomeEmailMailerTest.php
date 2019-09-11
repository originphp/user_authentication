<?php
namespace UserAuthentication\Test\Mailer;

use Origin\TestSuite\OriginTestCase;
use UserAuthentication\Mailer\WelcomeEmailMailer;
use Origin\Model\Entity;

class WelcomeEmailMailerTest extends OriginTestCase
{
    public function testExecute()
    {
        $user = new Entity([], ['name'=>'User']);
        $user->first_name = 'Jim';
        $user->email = 'jim@originphp.com';

        $message = (new WelcomeEmailMailer())->dispatch($user, 123456);
        $this->assertContains('To: jim@originphp.com', $message->header());
        $this->assertContains('From: Web Application <no-reply@example.com>', $message->header());
        $this->assertContains('<p>Thank you for signing up</p>', $message->body());
        $this->assertContains('Hi Jim', $message->body());
    }
}
