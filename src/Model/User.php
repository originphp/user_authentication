<?php

namespace UserAuthentication\Model;

use ArrayObject;
use Origin\Model\Entity;
use Origin\Security\Security;
use App\Model\ApplicationModel;
use Origin\Model\Concern\Delocalizable;
use Origin\Model\Concern\Timestampable;

class User extends ApplicationModel
{
    use Delocalizable,Timestampable;

    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->validate('first_name', 'required');
        $this->validate('last_name', 'required');
        $this->validate('email', [
            'required',
            [
                'rule' => 'customEmail',
                'message' => __('Invalid email address')
            ],
            [
                'rule' => 'isUnique',
                'message' => __('Email address already in use')
            ],
            [
                'rule' => ['minLength', 3],
                'message' => __('Minimum length 3 characters')
            ],
            [
                'rule' => ['maxLength',255],
                'message' => __('Maximum number of 255 characters')
            ]
        ]);
        $this->validate('password', [
            'required',
            [
                'rule' => '/[0-9]/',
                'message' => __('Must contain at least one digit')
            ],
            [
                'rule' => '/[a-z]/',
                'message' => __('Must contain at least one lowercase letter')
            ],
            [
                'rule' => '/[A-Z]/',
                'message' => __('Must contain at least one uppercase letter')
            ],
            [
                'rule' => ['minLength', 8],
                'message' => __('Minimum length 8 characters')
            ],
            [
                'rule' => ['maxLength',32],
                'message' => __('Maximum number of 32 characters')
            ]
        ]);
        // Register callbacks
        $this->beforeCreate('generateToken');
        $this->beforeSave('hashPassword');
    }

    /**
     * Callback
     *
     * @param \Origin\Model\Entity $entity
     * @param ArrayObject $options
     * @return bool
     */
    protected function generateToken(Entity $entity, ArrayObject $options): bool
    {
        $entity->token = Security::uuid();

        return true;
    }

    /**
     * Callback
     *
     * @param \Origin\Model\Entity $entity
     * @param ArrayObject $options
     * @return bool
     */
    protected function hashPassword(Entity $entity, ArrayObject $options): bool
    {
        if (! empty($entity->password) && in_array('password', $entity->modified())) {
            $entity->password = Security::hashPassword($entity->password);
        }

        return true;
    }

    /**
     * Custom email validation rule, checks that it is valid format and that domains' DNS
     * is configured for email (MX records)
     *
     * @param string $email
     * @return bool
     */
    public function customEmail(string $email): bool
    {
        $mxhosts = null;
        if (filter_var($email, FILTER_VALIDATE_EMAIL) !== false) {
            list($account, $domain) = explode('@', $email);
            getmxrr($domain, $mxhosts, $weight);
        }

        return ! empty($mxhosts);
    }
}
