<?php

use app\core\form\Form;
use app\core\Application;

?>
<?php Form::begin('addEquipment', '', 'post') ?>
<div class="text header">Add equipment!</div>
<div class="container" style="text-align: right;">
    <div class="row">
        <div class="col">
            <?php Form::inputField(Application::$APP->model, 'itemName', 'text', 'autofocus') ?><?php Form::inputField(Application::$APP->model, 'quantity', 'number') ?>
        </div>
    </div>
</div>
<div class="submitContainer">
    <input class="submit" type="submit" form="addEquipment" name="addMore" value="ADD ITEM">
    <div class="spacer"></div>
    <input class="submitAll" type="submit" form="addEquipment" name="addLast" value="Continue">
</div>
<?php Form::end() ?>