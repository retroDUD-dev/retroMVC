<?php

use app\core\form\Form;
use app\core\Application;

?>
<?= Form::begin('addEquipment', '', 'post') ?>
<div class="text header">Add equipment!</div>
<div class="container" style="text-align: right;">
    <div class="row">
        <div class="col">
            <?= Form::inputField($model, 'itemName', '', 'autofocus') ?><?= Form::inputField($model, 'quantity')->numberField() ?>
        </div>
    </div>
</div>
<div class="submitContainer">
    <?= Form::button($model, 'addMore', "ADD ITEM") ?>
    <div class="spacer"></div>
    <input class="submitAll" type="submit" form="addEquipment" name="addLast" value="Continue">
</div>
<?= Form::end() ?>