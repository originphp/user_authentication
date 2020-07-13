<?php
namespace UserAuthentication\Test\Model;

use Origin\TestSuite\OriginTestCase;

/**
 * @property \App\Model\User $User
 */
class UserTest extends OriginTestCase
{
    protected $fixtures = ['UserAuthentication.User'];

    public function startup(): void
    {
        $this->loadModel('UserAuthentication.User');
    }

    public function testBeforeSave()
    {
        $user = $this->User->find('first');

        $before = $user->password;
        $user->password = 'xxxxxxx';

        $this->assertTrue($this->User->save($user));
        $this->assertNotEquals($before, $user->password);
        $this->assertEquals('$2y$10', substr($user->password, 0, 6));
        $this->assertEquals(60, strlen($user->password));
    }
}
