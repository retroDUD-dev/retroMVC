<?php

use app\core\form\Form;
use app\core\Application;

?>
<?php Form::begin('addAttack', '', 'post') ?>
<div class="text header">Add attacks!</div>
<div class="container" style="text-align: right;">
    <div class="row">
        <div class="col">
            <?php Form::inputField(Application::$APP->model, 'attackName', 'text', 'autofocus') ?>
            <br>
            <?php Form::inputField(Application::$APP->model, 'bonus', 'number') ?>
            <br>
            <?php Form::inputField(Application::$APP->model, 'numberOfDice', 'number') ?><?php Form::inputField(Application::$APP->model, 'sidesOfDice', 'number') ?>
            <br>
            <?php Form::inputField(Application::$APP->model, 'type') ?>
            <br>
            <?php Form::inputField(Application::$APP->model, 'comment') ?>
            <br>
        </div>
    </div>
</div>
<div class="submitContainer">
    <input class="submit" type="submit" form="addAttack" name="addMore" value="ADD ATTACK">
    <div class="spacer"></div>
    <input class="submitAll" type="submit" form="addAttack" name="addLast" value="Continue">
</div>
<?php Form::end() ?>