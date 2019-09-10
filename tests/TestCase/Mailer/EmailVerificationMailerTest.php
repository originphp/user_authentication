<?php
namespace UserManagement\Test\Mailer;

use Origin\TestSuite\OriginTestCase;
use UserManagement\Mailer\EmailVerificationMailer;
use Origin\Model\Entity;

class EmailVerificationMailerTest extends OriginTestCase
{
    public function testExecute()
    {
        $user = new Entity(['name'=>'User']);
        $user->first_name = 'Jim';
        $user->email = 'jim@originphp.com';

        $message = (new EmailVerificationMailer())->dispatch($user, 123456);
        $this->assertContains('To: jim@originphp.com', $message->header());
        $this->assertContains('From: Web Application <no-reply@example.com>', $message->header());
        $this->assertContains('<a href="http://localhost:8000/verify">', $message->body());
        $this->assertContains('123456', $message->body());
    }
}
