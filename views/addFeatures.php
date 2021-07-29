<?php

use app\core\form\Form;
use app\core\Application;

?>
<?php Form::begin('addFeatures', '', 'post') ?>
<div class="text header">Add Features!</div>
<div class="container" style="text-align: right;">
    <div class="row">
        <div class="col">
            <?php Form::inputField(Application::$APP->model, 'featureName', 'text', 'autofocus') ?>
            <br>
            <?php Form::textarea(Application::$APP->model, 'description') ?>
        </div>
    </div>
</div>
<div class="submitContainer">
    <input class="submit" type="submit" form="addFeatures" name="addMore" value="ADD FEATURE">
    <div class="spacer"></div>
    <input class="submitAll" type="submit" form="addFeatures" name="addLast" value="Continue">
</div>
<?php Form::end() ?>