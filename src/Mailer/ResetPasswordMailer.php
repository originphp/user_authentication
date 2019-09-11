<?php
namespace UserAuthentication\Mailer;

use App\Mailer\AppMailer;
use Origin\Core\Config;
use Origin\Model\Entity;

class ResetPasswordMailer extends AppMailer
{
    public $folder = 'UserAuthentication.ResetPassword';

    public function execute(Entity $user, string $uuid)
    {
        $this->user = $user;
        $this->url = Config::read('App.url') . '/change_password/' . $uuid;
        $this->app = Config::read('App.name');
        
        $this->mail([
            'to' => $user->email,
            'subject' => 'Password Reset'
        ]);
    }
}
