<?php
namespace UserAuthentication\Test\Mailer;

use Origin\Core\Config;
use Origin\Model\Entity;
use Origin\Security\Security;
use Origin\TestSuite\OriginTestCase;
use UserAuthentication\Mailer\ResetPasswordMailer;

class ResetPasswordMailerTest extends OriginTestCase
{
    public function testExecute()
    {
        $user = new Entity(['name' => 'User']);
        $user->first_name = 'Jim';
        $user->email = 'jim@originphp.com';

        $code = Security::uuid();
        $url = Config::read('App.url');
     
        $message = (new ResetPasswordMailer())->dispatch($user, $code);
        $this->assertStringContainsString('To: jim@originphp.com', $message->header());
        $this->assertStringContainsString('From: Web Application <no-reply@example.com>', $message->header());
        $this->assertStringContainsString('<a href="'.$url.'/change_password/' . $code .'">', $message->body());
    }
}
