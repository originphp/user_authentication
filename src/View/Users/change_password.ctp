<?php
/**
 * @var \App\View\AppView $this
 */
use Origin\Core\Config;

echo $this->Html->css('UserAuthentication.form');
?>
<div class="form-header">
   <h2><?= Config::read('App.name'); ?></h2>
</div>
<div class="vertical-form">
   <p>Enter your new password.</p>
   <?php
   echo $this->Form->create();
   echo $this->Form->control('password');
   echo $this->Form->button(__('Change Password'), ['type' => 'submit', 'class' => 'btn btn-success btn-lg']);
   echo $this->Form->end();
   ?>
</div>
