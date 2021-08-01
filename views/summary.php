<?php

use app\core\form\Form;
use app\core\Application;
use app\models\PDF;

$character = Application::$APP->session->get('newCharacter')->nameCharacter();
?>
<?php Form::begin('characterCreated', '', 'post') ?>
<div class="text header">Summary</div>
<div class="containerCol">
    <?php PDF::create($character, '/public_html/tmp/') ?>
    <div class="row">
        <img src='<?= "/tmp/" . substr($character->getFile(), 0, -4) . ".jpg" ?>'>
    </div>
    <div class="buttonContainerCol">
        <div class="innerContainer">
            <?php Form::button($character, 'upload', 'Upload character') ?>
            <div class="text inner">Allow other people to access my character?
                <div style="height: 5px;"></div>
                <div class="check">
                    Yes<?php Form::radio($character, 'isPublic', 'YES', 'checked') ?>
                </div>
                <div class="check">
                    No<?php Form::radio($character, 'isPublic') ?>
                </div>
                <div style="height: 10px;"></div>
            </div>
        </div>
        <div class="row">
            <?php Form::button($character, 'saveFile', 'Save locally') ?>
        </div>
        <div class="row">
            <?php Form::button($character, 'downloadPdf', 'Download PDF') ?>
        </div>
        <div class="row">
            <?php Form::button($character, 'newCharacter', 'Create a new character') ?>
        </div>
    </div>
</div>
<div class="submitContainer"></div>
</form>