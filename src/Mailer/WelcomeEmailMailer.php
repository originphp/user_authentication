<?php
namespace UserAuthentication\Mailer;

use App\Mailer\AppMailer;
use Origin\Core\Config;
use Origin\Model\Entity;

class WelcomeEmailMailer extends AppMailer
{
    public $folder = 'UserAuthentication.WelcomeEmail';

    public function execute(Entity $user)
    {
        $this->user = $user;
        $this->url = Config::read('App.url');
        $this->app = Config::read('App.name');

        $this->mail([
            'to' => $user->email,
            'subject' => 'Welcome to ' . $this->app
        ]);
    }
}
