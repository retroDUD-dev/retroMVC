<?php

use app\core\Application;
use app\core\form\Form;

if (!isset($disabled)) {
    $disabled = '';
}
?>
<div class="header text">My profile</div>
<?= Form::begin('userProfile', '', 'post') ?>
<div class="containerCol">
    <?= Form::inputField($model, 'displayName', '', $disabled) ?>
    <br>
    <?= Form::inputField($model, 'firstname', '', $disabled) ?>
    <br>
    <?= Form::inputField($model, 'lastname', '', $disabled) ?>
    <br>
    <?= Form::inputField($model, 'email', '', $disabled)->emailField() ?>
    <br>
    <?php if ($disabled === 'disabled') : ?>
        <?= Form::button($model, 'edit', 'Edit') ?>
    <?php else : ?>
        <?= Form::button($model, 'save', 'Save') ?>
    <?php endif; ?>
    <br>
</div>
<div class="submitContainer">
    <div class="innerContainer">
        <?= Form::button($model, 'resetPassword', 'Reset password') ?>
        <?= Form::button($model, 'deactivate', 'deactivate') ?>
        <?= Form::button($model, 'delete', 'delete') ?>
    </div>
</div>
<?= Form::end(); ?>