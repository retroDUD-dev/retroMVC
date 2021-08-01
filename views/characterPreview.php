<?php

use app\core\form\Form;

?>
<?php Form::begin('modelViewed', '', 'post') ?>
<div class="text header">
    <?= $model->getName()."'s model sheet" ?>
</div>
<div class="containerCol">
    <div class="row">
        <img src='<?= "/tmp/" . substr($model->getFile(), 0, -4) . ".jpg" ?>'>
    </div>
    <div class="buttonContainerCol">
        <div class="row">
            <?php Form::button($model, 'downloadPdf', 'Download PDF') ?>
        </div>
        <div class="row">
            <?php Form::button($model, 'saveFile', 'Save locally') ?>
        </div>
        <div class="row">
            <?php Form::button($model, 'messageOwner', 'Message creator') ?>
        </div>
    </div>
</div>
<div class="submitContainer"></div>
</form>