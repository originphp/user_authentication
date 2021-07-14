<?php
declare(strict_types = 1);
namespace UserAuthentication\Form;

use Origin\Model\Record;

class LoginForm extends Record
{
    /**
     * Setup the schema and validation rules here
     *
     * @example
     *
     *   $this->addField('name', ['type'=>'string','length'=>255]);
     *   $this->validate('name', 'required');
     *
     * @return void
     */
    protected function initialize(): void
    {
    }
}
