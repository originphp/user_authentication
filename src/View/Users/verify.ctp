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
   <p>Enter the verification code you received in the email.</p>
   <?php
    echo $this->Form->create($user);
    echo $this->Form->control('code');
    echo $this->Form->button(__('Verify'), ['type' => 'submit', 'class' => 'btn btn-success btn-lg']);
    echo $this->Form->end();
   ?>
</div>