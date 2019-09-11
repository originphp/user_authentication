<?php
namespace UserAuthentication\Test\Mailer;

use Origin\TestSuite\OriginTestCase;
use Origin\Model\Entity;
use UserAuthentication\Mailer\ResetPasswordMailer;

class ResetPasswordMailerTest extends OriginTestCase
{
    public function testExecute()
    {
        $user = new Entity(['name'=>'User']);
        $user->first_name = 'Jim';
        $user->email = 'jim@originphp.com';

        $code = uuid();
     
        $message = (new ResetPasswordMailer())->dispatch($user, $code);
        $this->assertContains('To: jim@originphp.com', $message->header());
        $this->assertContains('From: Web Application <no-reply@example.com>', $message->header());
        $this->assertContains('<a href="http://localhost:8000/change_password/' . $code .'">', $message->body());
    }
}
