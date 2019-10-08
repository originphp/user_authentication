<?php
namespace UserAuthentication\Http\Controller;

use Origin\Model\Entity;
use Origin\Utility\Security;
use Origin\Exception\InternalErrorException;
use Origin\Http\Exception\NotFoundException;
use App\Http\Controller\ApplicationController;
use UserAuthentication\Mailer\WelcomeEmailMailer;
use UserAuthentication\Mailer\ResetPasswordMailer;
use UserAuthentication\Mailer\EmailVerificationMailer;

/**
 * @property \UserAuthentication\Model\User $User
 */
class UsersController extends ApplicationController
{
    protected $layout = 'UserAuthentication.form';
    
    public function initialize() : void
    {
        parent::initialize();
        $this->Auth->allow([
            'signup', 'verify', 'forgot_password', 'change_password'
        ]);
    }
   
    public function signup()
    {
        $user = $this->User->new();

        if ($this->request->is(['post'])) {
            $user = $this->User->new($this->request->data());

            if ($this->User->save($user)) {
                if (! (new WelcomeEmailMailer())->dispatchLater($user)) {
                    throw new InternalErrorException('Error dispatching mailer');
                }

                $this->Flash->success(__('Your account has been created.'));

                return $this->redirect('/login');
            }

            $this->Flash->error(__('You account could not be created.'));
        }
        $this->set('user', $user);
    }
   
    public function login()
    {
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                if (! $user->verified or strtotime($user->verified . ' + 30 days') < time()) {
                    $this->sendEmailVerificationMailer($user);

                    return $this->redirect('/verify');
                }
                $this->Auth->login($user);

                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error(__('Incorrect username or password.'));
        }
    }

    public function verify()
    {
        $user = $this->User->new();
        
        if ($this->request->is(['post'])) {
            $verificationCode = (int) $this->Session->read('Verification.code');
            $postedCode = (int) $this->request->data('code');
          
            if ($postedCode and $postedCode === $verificationCode) {
                $userId = $this->Session->read('Verification.user_id');
                $this->User->updateColumn($userId, 'verified', date('Y-m-d H:i:s'));
                $this->Flash->success(__('You have been verified, you can now login.'));

                return $this->redirect('/login');
            } else {
                $this->Flash->error(__('Invalid verification code'));
            }
        }
        $this->set('user', $user);
    }

    public function forgot_password()
    {
        $user = $this->User->new();
        if ($this->request->is(['post'])) {
            $user = $this->User->new($this->request->data());

            # Overwrite validation rule for email
            $this->User->validate('email', 'email');

            if ($this->User->validates($user)) {
                $user = $this->User->find('first', [
                    'conditions' => ['email' => $this->request->data('email')]
                ]);
                if ($user) {
                    $this->sendResetPasswordMailer($user);
                }
                $this->Flash->info(__('If the email address is found an email will be sent.'));
            }
        }
        $this->set('user', $user);
    }

    public function change_password($code = null)
    {
        $user = $this->User->new();

        if (is_null($code) or $code != $this->Session->read('PasswordReset.code')) {
            throw new NotFoundException('Not found');
        }
        if ($this->request->is(['post'])) {
            $user->id = $this->Session->read('PasswordReset.user_id');
       
            $user->password = $this->request->data('password');
            if ($this->User->save($user)) {
                $this->Flash->success(__('Your password has been changed.'));
                $this->Session->delete('PasswordReset.code');

                return $this->redirect('/login');
            } else {
                $this->Flash->error(__('An Error has Occured'));
            }
        }
        $this->set('user', $user);
    }

    public function logout()
    {
        $this->Flash->success(__('You have been logged out.'));

        return $this->redirect($this->Auth->logout());
    }

    public function token()
    {
        $this->layout = 'default';
        $userId = $this->Auth->user('id');
        $user = $this->User->get($userId);

        if ($this->request->is(['post'])) {
            $user->token = Security::uuid();
            if ($this->User->save($user)) {
                $this->Flash->success(__('Your API token has been changed'));
                $this->Auth->login($user);
            } else {
                $this->Flash->error(__('Unable to issue a new API Token'));
            }
        }

        $this->set('user', $user);
    }

    public function profile()
    {
        $this->layout = 'default';
        
        $user = $this->User->get($this->Auth->user('id'));

        if ($this->request->is(['post'])) {
            $user = $this->User->patch($user, $this->request->data(), [
                'fields' => ['first_name','last_name','email']
            ]);
      
            if ($this->User->save($user)) {
                $this->Flash->success(__('Your profile has been updated.'));
                $this->Auth->login($user);
            } else {
                $this->Flash->error(__('Your profile could not be updated.'));
            }
        }
        $this->set('user', $user);
    }

    private function sendResetPasswordMailer(Entity $user)
    {
        $uid = Security::uid();

        # Create Session Details
        $this->Session->write('PasswordReset.user_id', $user->id);
        $this->Session->write('PasswordReset.code', $uid);

        if (! (new ResetPasswordMailer())->dispatchLater($user, $uid)) {
            throw new InternalErrorException('Error dispatching mailer');
        }
    }

    private function sendEmailVerificationMailer(Entity $user)
    {
        $code = mt_rand(100000, 999900);
        $this->Session->write('Verification.user_id', $user->id);
        $this->Session->write('Verification.code', $code);

        if (! (new EmailVerificationMailer())->dispatchLater($user, $code)) {
            throw new InternalErrorException('Error dispatching mailer');
        }
    }
}
