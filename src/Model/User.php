<?php
namespace UserManagement\Model;

use Origin\Model\Entity;
use Origin\Utility\Security;

class User extends UserManagementAppModel
{
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->validate('first_name', 'notBlank');
        $this->validate('last_name', 'notBlank');
        $this->validate('email', [
            ['rule'=>'notBlank'],
            ['rule'=>'email','allowBlank' => true],
        ]);
        $this->validate('password', [
            'rule' => 'alphaNumeric',
             'rule'=>['minLength',6]
         ]);
    }


    /**
     * Before save callback
     *
     * @param \Origin\Model\Entity $entity
     * @param array $options
     * @return bool must return true to continue
     */
    public function beforeSave(Entity $entity, array $options = [])
    {
        if (! empty($entity->password) and in_array('password', $entity->modified())) {
            $entity->password = Security::hashPassword($entity->password);
        }
    }
}
