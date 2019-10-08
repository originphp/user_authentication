<?php
namespace UserAuthentication\Test\Fixture;

use Origin\TestSuite\Fixture;

class UserFixture extends Fixture
{
    protected $records = [
        [
            'id' => 1000,
            'first_name' => 'Jon',
            'last_name' => 'Snow',
            'email' => 'jon.snow@originphp.com',
            'password' => '$2y$10$nCMxYLvcvbXFnsBDFP5WpOky3bz.EDgo54VR0Tg9cpave3ZETT/di', // 123456
            'token' => '3905604a-b14d-4fe8-906e-7867b39289b3',
            'description' => null,
            'verified' => '2019-09-10 14:17:13',
            'created' => '2019-09-10 14:16:40',
            'modified' => '2019-09-10 14:24:02'
        ]
    ];
}
