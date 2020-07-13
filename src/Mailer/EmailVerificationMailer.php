<?php
namespace UserAuthentication\Mailer;

use Origin\Core\Config;
use Origin\Model\Entity;
use App\Mailer\ApplicationMailer;

class EmailVerificationMailer extends ApplicationMailer
{
    public function execute(Entity $user, int $code): void
    {
        $this->user = $user;
        $this->url = Config::read('App.url');
        $this->code = $code;
        $this->app = Config::read('App.name');
        
        $this->mail([
            'to' => $user->email,
            'subject' => 'Verify your email address'
        ]);
    }
}
