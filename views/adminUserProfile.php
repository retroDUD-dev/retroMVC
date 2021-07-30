<?php

use app\core\Application;
use app\core\form\Form;

if (!isset($disabled)) {
    $disabled = '';
}
$model = Application::$APP->session->get('profileUser')
?>
<div class="header text"><?= $model->getDisplayName() ?>'s profile</div>
<?php Form::begin('adminUserProfile', '', 'post') ?>
<div class="containerCol">
    <?php Form::inputField($model, 'firstname', 'text', $disabled) ?>
    <br>
    <?php Form::inputField($model, 'lastname', 'text', $disabled) ?>
    <br>
    <?php Form::inputField($model, 'email', 'email', $disabled) ?>
    <br>
    <?php if ($disabled === 'disabled') : ?>
        <?php Form::button($model, 'edit', 'Edit') ?>
    <?php else : ?>
        <?php Form::button($model, 'save', 'Save') ?>
    <?php endif; ?>
    <br>
</div>
<div class="submitContainer">
    <div class="innerContainer">
        <?php Form::button($model, 'resetPassword', 'Reset password') ?>
        <?php Form::button($model, 'deactivate', 'deactivate') ?>
        <?php Form::button($model, 'delete', 'delete') ?>
    </div>
</div>
<?php Form::end(); ?>