<?php
namespace UserAuthentication\Mailer;

use App\Mailer\ApplicationMailer;
use Origin\Core\Config;
use Origin\Model\Entity;

class WelcomeEmailMailer extends ApplicationMailer
{
    public $folder = 'UserAuthentication.WelcomeEmail';

    public function execute(Entity $user) : void
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
