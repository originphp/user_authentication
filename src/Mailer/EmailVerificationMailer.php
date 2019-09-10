<?php
namespace UserManagement\Mailer;

use App\Mailer\AppMailer;
use Origin\Core\Config;
use Origin\Model\Entity;

class EmailVerificationMailer extends AppMailer
{
    public $folder = 'UserManagement.EmailVerification';
    
    public function execute(Entity $user, int $code)
    {
        $this->user = $user;
        $this->url = Config::read('App.url');
        $this->code = $code;
        
        $this->mail([
            'to' => $user->email,
            'subject' => 'Verify your email address'
        ]);
    }
}
