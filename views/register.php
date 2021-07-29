<?php

use app\core\form\Form;

?>
<div class="header text">Sign Up</div>
<div class="containerCol">
    <div class="row">
        <div class="col text">Please fill this form to create an account.</div>
    </div>
    <div class="innerContainer" style="text-align: right;">
        <?php $form = Form::begin('register', '', "post") ?>
        <br>
        <?php Form::inputField($model, 'firstname', 'text', 'autofocus') ?>
        <?php Form::inputField($model, 'lastname') ?>
        <br>
        <?php Form::inputField($model, 'email') ?>
        <br>
        <?php Form::inputField($model, 'password', 'password') ?>
        <br>
        <?php Form::inputField($model, 'confirmPassword', 'password') ?>
        <div class="text inner">
            <input type="submit" class="submit" name="register" value="Submit">
            <input type="reset" class="submit" value="Reset">
        </div>
        <?php Form::end() ?>
    </div>
</div>
<div class="submitContainer">
    <div class="text">Already have an account? <a class="text" href="/Login">Login here.</a></div>
</div>