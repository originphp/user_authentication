<?php
use Origin\Model\Schema;

class ApplicationSchema extends Schema
{
    const VERSION = 20190904013421;

    public $users = [
        'columns' => [
            'id' => ['type' => 'integer', 'limit' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'autoIncrement' => true],
            'first_name' => ['type' => 'string', 'limit' => 40, 'null' => false, 'default' => null],
            'last_name' => ['type' => 'string', 'limit' => 80, 'null' => false, 'default' => null],
            'email' => ['type' => 'string', 'limit' => 255, 'null' => true, 'default' => null],
            'password' => ['type' => 'string', 'limit' => 255, 'null' => false, 'default' => null],
            'description' => ['type' => 'text', 'null' => true, 'default' => null],
            'token' => ['type' => 'text', 'limit' => 60, 'null' => false, 'default' => null],
            'verified' => ['type' => 'datetime', 'null' => true, 'default' => null],
            'created' => ['type' => 'datetime', 'null' => true, 'default' => null],
            'modified' => ['type' => 'datetime', 'null' => false, 'default' => null]
        ],
        'constraints' => [
            'primary' => ['type' => 'primary', 'column' => 'id']
        ],
        'indexes' => [],
        'options' => ['engine' => 'InnoDB', 'autoIncrement' => 1000]
    ];
}
