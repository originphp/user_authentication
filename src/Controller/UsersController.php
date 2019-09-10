<?php
namespace UserManagement\Controller;

use Origin\Model\Entity;
use UserManagement\Mailer\EmailVerificationMailer;
use UserManagement\Mailer\ResetPasswordMailer;
use Origin\Exception\InternalErrorException;
use Origin\Exception\NotFoundException;

/**
 * @property \App\Model\User $User
 */
class UsersController extends UserManagementAppController
{
    public $layout = 'UserManagement.form';
    
    public function initialize()
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
            $user = $this->User->new();
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


    private function sendResetPasswordMailer(Entity $user)
    {
        $uuid = uid();

        # Create Session Details
        $this->Session->write('PasswordReset.user_id', $user->id);
        $this->Session->write('PasswordReset.code', $uuid);

        if (! (new ResetPasswordMailer())->dispatchLater($user, $uuid)) {
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
