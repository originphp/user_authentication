<?php
/**
 * @var \App\Http\View\ApplicationView $this
 */
use Origin\Core\Config;

echo $this->Html->css('UserAuthentication.form');
?>
<div class="form-header">
   <h2><?= Config::read('App.name'); ?></h2>
</div>
<div class="vertical-form">
   <p>Login to continue</p>
   <?php
   echo $this->Form->create();
   echo $this->Form->control('email');
   echo $this->Form->control('password');
   echo $this->Form->button(__('Login'), ['type' => 'submit', 'class' => 'btn btn-success btn-lg']);
   echo $this->Form->end();
   ?>
   <div class='vertical-form-footer'>
      <a href="/forgot_password">Forgot password?</a>
   </div>
</div>
