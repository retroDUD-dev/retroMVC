<?php

use app\core\form\Form;

?>
<?= Form::begin('addAttack', '', 'post') ?>
<div class="text header">Add attacks!</div>
<div class="container" style="text-align: right;">
    <div class="row">
        <div class="col">
            <?= Form::inputField($model, 'attackName', '', 'autofocus') ?>
            <br>
            <?= Form::inputField($model, 'bonus')->numberField() ?>
            <br>
            <?= Form::inputField($model, 'numberOfDice')->numberField() ?><?= Form::inputField($model, 'sidesOfDice')->numberField() ?>
            <br>
            <?= Form::inputField($model, 'type') ?>
            <br>
            <?= Form::inputField($model, 'comment') ?>
            <br>
        </div>
    </div>
</div>
<div class="submitContainer">
    <?= Form::button($model, 'addMore', "ADD ATTACK") ?>
    <div class="spacer"></div>
    <input class="submitAll" type="submit" form="addAttack" name="addLast" value="Continue">
</div>
<?= Form::end() ?>