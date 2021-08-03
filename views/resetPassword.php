<?php

use app\core\Application;
use app\core\form\Form;

?>
<div class="header text">Reset Password</div>
<div class="containerCol" style="text-align: right;">
    <div class="row text">Please fill out this form to reset your password.</div>
    <?= Form::begin('newPassword', '', "post") ?>
    <div class="innerContainer">
        <br>
        <?php if (Application::$APP->session->getFlash('fail')) : ?>
            <div class="error">
                <?= Application::$APP->session->getFlash('fail'); ?>
            </div>
            <?= Form::inputField($model, 'oldPassword', '', 'style="border: 3px solid var(--error-color);" autofocus')->passwordField() ?>
        <?php else : ?>
            <?= Form::inputField($model, 'oldPassword', '', 'autofocus')->passwordField() ?>
        <?php endif; ?>
        <br>
        <?= Form::inputField($model, 'newPassword')->passwordField() ?>
        <br>
        <?= Form::inputField($model, 'confirmNewPassword')->passwordField() ?>
        <br>
        <?= Form::button($model, 'submit', 'Submit') ?>
        <?php if (Application::isAdmin() && str_contains(Application::$APP->request?->getPath(), "/Admin") && $model->getDisplayName() !== Application::$APP->session->get('user')['displayName']) : ?>
        <a class="text" href="/Admin/UserProfile">Cancel</a>
        <?php else : ?>
        <a class="text" href="/MyAccount/MyProfile">Cancel</a>
        <?php endif; ?>
    </div>
    <?= Form::end() ?>
</div>
<div class="submitContainer"></div>