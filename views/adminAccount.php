<?php

use app\core\Application;
use app\core\form\Form;

$this->title = 'My Account';

?>
<div class="header text">Hello admin, <?= Application::$APP->session->get('admin')['displayName']; ?>!</div>
<div class="containerCol">
    <div class="row text">
        How would you like to proceed?
    </div>
    <div class="innerContainer">
        <div class="container">
            <?php Form::begin('adminOptions', '', 'post') ?>
            <div class="row">
                <?php Form::button($model, 'userSearch', 'user search') ?>
                <br>
            </div>
            <?php Form::end() ?>
        </div>
    </div>
</div>
<div class="submitContainer"></div>