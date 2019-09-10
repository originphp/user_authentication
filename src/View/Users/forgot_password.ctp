<?php
/**
 * @var \App\View\AppView $this
 */
use Origin\Core\Config;

echo $this->Html->css('UserManagement.form');
?>
<div class="form-header">
   <h2><?= Config::read('App.name'); ?></h2>
</div>
<div class="vertical-form">
   <p>Enter your email address and we will send you a link to reset your password.</p>
   <?php
   echo $this->Form->create();
   echo $this->Form->control('email');
   echo $this->Form->button(__('Request Password Reset'), ['type' => 'submit', 'class' => 'btn btn-success btn-lg']);
   echo $this->Form->end();
   ?>
</div>
