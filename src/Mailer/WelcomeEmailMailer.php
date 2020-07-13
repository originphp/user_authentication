<?php
namespace UserAuthentication\Mailer;

use Origin\Core\Config;
use Origin\Model\Entity;
use App\Mailer\ApplicationMailer;

class WelcomeEmailMailer extends ApplicationMailer
{
    public function execute(Entity $user): void
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
