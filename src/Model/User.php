<?php
namespace UserAuthentication\Model;

use App\Model\AppModel;
use Origin\Model\Entity;
use Origin\Utility\Security;

class User extends AppModel
{
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->validate('first_name', 'notBlank');
        $this->validate('last_name', 'notBlank');
        $this->validate('email', [
            ['rule'=>'notBlank'],
            ['rule'=>'customEmail','allowBlank' => false,'message'=>'Invalid email address'],
            ['rule' => 'isUnique','message' => 'Email address already in use','allowBlank' => true],
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
        if ($entity->id === null) {
            $entity->token = Security::uuid();
        }
        if (! empty($entity->password) and in_array('password', $entity->modified())) {
            $entity->password = Security::hashPassword($entity->password);
        }
    }

    /**
     * Custom email validation rule, checks that it is valid format and that domains' DNS
     * is configured for email (MX records)
     *
     * @param string $email
     * @return void
     */
    public function customEmail(string $email)
    {
        $result = false;
        if (filter_var($email, FILTER_VALIDATE_EMAIL) !== false) {
            list($account, $domain) = explode('@', $email);
            getmxrr($domain, $mxhosts, $weight);
            if ($mxhosts) {
                $result = true;
            }
        }
        return $result;
    }
}
