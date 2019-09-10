<?php
namespace UserManagement\Test\Fixture;

use Origin\TestSuite\Fixture;

class UserFixture extends Fixture
{
    public $records = [
        [
            'id' => 1000,
            'first_name' => 'Jon',
            'last_name' => 'Snow',
            'email' => 'jon.snow@originphp.com',
            'password' => '$2y$10$nCMxYLvcvbXFnsBDFP5WpOky3bz.EDgo54VR0Tg9cpave3ZETT/di', // 123456
            'description' => null,
            'verified' => '2019-09-10 14:17:13',
            'created' => '2019-09-10 14:16:40',
            'modified' => '2019-09-10 14:24:02'
        ]
    ];
}
