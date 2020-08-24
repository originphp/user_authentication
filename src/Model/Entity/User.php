<?php
namespace App\Model\Entity;

use Origin\Model\Entity;

class User extends Entity
{
    protected $virtual = ['name'];

    protected function getName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
