<?php

use app\core\form\Form;

?>
<div class="header text">Sign Up</div>
<div class="containerCol">
    <div class="row">
        <div class="col text">Please fill this form to create an account.</div>
    </div>
    <div class="innerContainer" style="text-align: right;">
        <?= Form::begin('register', '', "post") ?>
        <br>
        <?= Form::inputField($model, 'displayName', '', 'autofocus') ?>
        <br>
        <?= Form::inputField($model, 'firstname') ?>
        <?= Form::inputField($model, 'lastname') ?>
        <br>
        <?= Form::inputField($model, 'email')->emailField() ?>
        <br>
        <?= Form::inputField($model, 'password')->passwordField() ?>
        <br>
        <?= Form::inputField($model, 'confirmPassword')->passwordField() ?>
        <div class="text inner">
            <?= Form::button($model, 'register', 'Submit') ?>
            <input type="reset" class="submit" value="Reset">
        </div>
        <?= Form::end() ?>
    </div>
</div>
<div class="submitContainer">
    <div class="text">Already have an account? <a class="text" href="/Login">Login here.</a></div>
</div>