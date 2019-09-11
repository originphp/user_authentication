<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="page-header">
    <h2><?= __('Profile'); ?></h2>
</div>
<div class="row">
    <div class="col col-fixed">
        <?= $this->Form->create($user); ?>
        <?php
            echo $this->Form->control('first_name');
            echo $this->Form->control('last_name');
            echo $this->Form->control('email');
            echo $this->Form->button(__('Save'), ['type'=>'submit','class' => 'btn btn-primary']);
            echo $this->Form->end();
        ?>
    </div>
</div>