<?php

use app\core\Application;
use app\core\form\Form;

?>
<div class="header text">Reset Password</div>
<div class="containerCol" style="text-align: right;">
    <div class="row text">Please fill out this form to reset your password.</div>
    <?php $form = Form::begin('newPassword', '', "post") ?>
    <div class="innerContainer">
        <br>
        <?php if (Application::$APP->session->getFlash('fail')) : ?>
            <div class="error">
                <?= Application::$APP->session->getFlash('fail'); ?>
            </div>
            <?php Form::inputField($model, 'oldPassword', 'password', 'style="border: 3px solid var(--error-color);" autofocus') ?>
        <?php else : ?>
            <?php Form::inputField($model, 'oldPassword', 'password', 'autofocus') ?>
        <?php endif; ?>
        <br>
        <?php Form::inputField($model, 'newPassword', 'password') ?>
        <br>
        <?php Form::inputField($model, 'confirmNewPassword', 'password') ?>
        <br>
        <?php Form::button($model, 'submit', 'Submit') ?>
        <a class="text" href="/MyAccount">Cancel</a>
    </div>
    <?php Form::end() ?>
</div>
<div class="submitContainer"></div>