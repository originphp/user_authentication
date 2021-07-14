<?php
declare(strict_types = 1);
namespace UserAuthentication\Test\TestCase\Form;

use Origin\TestSuite\OriginTestCase;
use UserAuthentication\Form\Login;

class LoginFormTest extends OriginTestCase
{
    public function testFormMethod()
    {
        $record = LoginForm::new();
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }
}