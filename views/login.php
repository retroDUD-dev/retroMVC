<?php

use app\core\Application;
use app\core\form\Form;

?>
<div class="header text">Login</div>
<div class="containerCol">
    <div class="row text">Please fill in your credentials to login.</div>
    <?= Form::begin('login', '', "post") ?>
    <div class="innerContainer">
        <div style="text-align: right;">
            <?php if (Application::$APP->session->getFlash('fail')) : ?>
                <div class="error">
                    <?= Application::$APP->session->getFlash('fail'); ?>
                </div>
            <?php else : ?>
                <br>
            <?php endif; ?>
            <?= Form::inputField($model, 'email', '',  'autofocus')->emailField() ?>
            <br>
            <?= Form::inputField($model, 'password')->passwordField() ?>
        </div>
        <?= Form::button($model, 'login', 'Login') ?>
    </div>
    </form>
</div>
<div class="submitContainer">
    <div class="text">Don't have an account? <a class="text" href="/Register">Sign up now.</a></div>
</div>