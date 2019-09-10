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
   <p>Signup</p>
   <?php
    echo $this->Form->create($user);
    echo $this->Form->control('first_name');
    echo $this->Form->control('last_name');
    echo $this->Form->control('email');
    echo $this->Form->control('password');
    echo $this->Form->button(__('Signup'), ['type' => 'submit', 'class' => 'btn btn-success btn-lg']);
    echo $this->Form->end();
   ?>
</div>
