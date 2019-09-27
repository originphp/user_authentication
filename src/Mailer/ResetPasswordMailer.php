<?php
namespace UserAuthentication\Mailer;

use App\Mailer\ApplicationMailer;
use Origin\Core\Config;
use Origin\Model\Entity;

class ResetPasswordMailer extends ApplicationMailer
{
    public $folder = 'UserAuthentication.ResetPassword';

    public function execute(Entity $user, string $uuid) : void
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
