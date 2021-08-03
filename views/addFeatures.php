<?php

use app\core\form\Form;
use app\core\Application;

?>
<?= Form::begin('addFeatures', '', 'post') ?>
<div class="text header">Add Features!</div>
<div class="container" style="text-align: right;">
    <div class="row">
        <div class="col">
            <?= Form::inputField($model, 'featureName', '', 'autofocus') ?>
            <br>
            <?= Form::textarea($model, 'description') ?>
        </div>
    </div>
</div>
<div class="submitContainer">
    <?= Form::button($model, 'addMore', "ADD FEATURE") ?>
    <div class="spacer"></div>
    <input class="submitAll" type="submit" form="addFeatures" name="addLast" value="Continue">
</div>
<?= Form::end() ?>