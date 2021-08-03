<?php

use app\core\Application;
use app\core\form\Form;


$model = Application::$APP->session->get('characterPreview');
?>
<?= Form::begin('modelViewed', '', 'post') ?>
<div class="text header">
    <?= $model->getName()."'s model sheet" ?>
</div>
<div class="containerCol">
    <div class="row">
        <img src='<?= "/tmp/" . substr($model->getFile(), 0, -4) . ".jpg" ?>'>
    </div>
    <div class="buttonContainerCol">
        <div class="row">
            <?= Form::button($model, 'downloadPdf', 'Download PDF') ?>
        </div>
        <div class="row">
            <?= Form::button($model, 'saveFile', 'Save locally') ?>
        </div>
        <div class="row">
            <?php //Form::button($model, 'messageOwner', 'Message creator') ?>
        </div>
    </div>
</div>
<div class="submitContainer"></div>
</form>