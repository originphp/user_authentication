<?php
/**
 * @var \App\Http\View\ApplicationView $this
 */

?>
<style>
.form-control-plaintext {
    padding:10px;
    background-color:#f5f5f5;
    max-width:500px;
}
</style>

<div class="page-header">
    <h2><?= __('API Token') ?></h2>
</div>
<div class="main">
    <p><?= __('Your API token is private, never share it with anybody.') ?></p>
    <div class="input text">
        <input type="text" readonly class="form-control-plaintext" name='api-token' id="api-token" value="<?= $user->token ?>">
    </div>
    <div class="buttons">
        <p> <?= $this->Form->postLink(__('Generate a new API Token'), '/token', ['class'=>'btn btn-primary']) ?> </p>
         
    </div>
</div>

<script>
$( document ).ready(function() {
  $("#api-token").on("click", function () {
     $(this).select();
    });
});
</script>