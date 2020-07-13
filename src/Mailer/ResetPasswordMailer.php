<?php
namespace UserAuthentication\Mailer;

use Origin\Core\Config;
use Origin\Model\Entity;
use App\Mailer\ApplicationMailer;

class ResetPasswordMailer extends ApplicationMailer
{
    public function execute(Entity $user, string $uuid): void
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
