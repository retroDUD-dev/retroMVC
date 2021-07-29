<?php

use app\core\form\Form;
use app\core\Application;

?>
<?php Form::begin('createNew', '', 'post') ?>
<div class="text header">Create a new character</div>
<div class="container" style="text-align: right;">
    <div class="col left">
        <?php Form::inputField(Application::$APP->model, 'name', 'text', 'autofocus') ?>
        <br>
        <?php Form::inputField(Application::$APP->model, 'class') ?>
        <br>
        <?php Form::inputField(Application::$APP->model, 'background') ?>
        <br>
        <?php Form::inputField(Application::$APP->model, 'race') ?>
        <br>
        <?php Form::inputField(Application::$APP->model, 'numberOfDice', 'number') ?><?php Form::inputField(Application::$APP->model, 'sidesOfDice', 'number') ?>
        <br>
        <div class="innerContainer">
            <div class="inner">
                <div class="text name inner">Attributes</div>
            </div>
            <?php Form::inputField(Application::$APP->model, 'attributes/strength', 'number') ?>
            <br>
            <?php Form::inputField(Application::$APP->model, 'attributes/dexterity', 'number') ?>
            <br>
            <?php Form::inputField(Application::$APP->model, 'attributes/constitution', 'number') ?>
            <br>
            <?php Form::inputField(Application::$APP->model, 'attributes/intelligence', 'number') ?>
            <br>
            <?php Form::inputField(Application::$APP->model, 'attributes/wisdom', 'number') ?>
            <br>
            <?php Form::inputField(Application::$APP->model, 'attributes/charisma', 'number') ?>
            <br>
        </div>
        <div class="innerContainer">
            <div class="inner">
                <div class="text name inner">Saving throws</div>
            </div>
            <?php Form::inputField(Application::$APP->model, 'savingThrows/strength', 'number') ?>
            <br>
            <?php Form::inputField(Application::$APP->model, 'savingThrows/dexterity', 'number') ?>
            <br>
            <?php Form::inputField(Application::$APP->model, 'savingThrows/constitution', 'number') ?>
            <br>
            <?php Form::inputField(Application::$APP->model, 'savingThrows/intelligence', 'number') ?>
            <br>
            <?php Form::inputField(Application::$APP->model, 'savingThrows/wisdom', 'number') ?>
            <br>
            <?php Form::inputField(Application::$APP->model, 'savingThrows/charisma', 'number') ?>
            <br>
        </div>
    </div>
    <div class="col center">
        <?php Form::inputField(Application::$APP->model, 'alignment') ?>
        <br>
        <?php Form::inputField(Application::$APP->model, 'proficiency', 'number') ?>
        <br>
        <?php Form::inputField(Application::$APP->model, 'armor', 'number') ?>
        <br>
        <?php Form::inputField(Application::$APP->model, 'initiative', 'number') ?>
        <br>
        <?php Form::inputField(Application::$APP->model, 'speed', 'number') ?>
        <br>
        <?php Form::inputField(Application::$APP->model, 'hitPoints', 'number') ?>
        <br>
        <?php Form::inputField(Application::$APP->model, 'personalityTraits') ?>
        <br>
        <?php Form::inputField(Application::$APP->model, 'ideals') ?>
        <br>
        <?php Form::inputField(Application::$APP->model, 'bonds') ?>
        <br>
        <?php Form::inputField(Application::$APP->model, 'flaws') ?>
        <br>
        <?php Form::textarea(Application::$APP->model, 'proficiencies') ?>
        <br>
        <?php Form::textarea(Application::$APP->model, 'languages') ?>
        <br>
        <?php Form::inputField(Application::$APP->model, 'money/CP', 'number') ?>
        <br>
        <?php Form::inputField(Application::$APP->model, 'money/SP', 'number') ?>
        <br>
        <?php Form::inputField(Application::$APP->model, 'money/EP', 'number') ?>
        <br>
        <?php Form::inputField(Application::$APP->model, 'money/GP', 'number') ?>
        <br>
        <?php Form::inputField(Application::$APP->model, 'money/PP', 'number') ?>
        <br>
    </div>
    <div class="col right">
        <div class="innerContainer">
            <div class="inner">
                <div class="text name inner">Skills</div>
            </div>
            <?php Form::inputField(Application::$APP->model, 'skills/acrobatics', 'number') ?>
            <br>
            <?php Form::inputField(Application::$APP->model, 'skills/animalHandling', 'number') ?>
            <br>
            <?php Form::inputField(Application::$APP->model, 'skills/arcana', 'number') ?>
            <br>
            <?php Form::inputField(Application::$APP->model, 'skills/athletics', 'number') ?>
            <br>
            <?php Form::inputField(Application::$APP->model, 'skills/deception', 'number') ?>
            <br>
            <?php Form::inputField(Application::$APP->model, 'skills/history', 'number') ?>
            <br>
            <?php Form::inputField(Application::$APP->model, 'skills/insight', 'number') ?>
            <br>
            <?php Form::inputField(Application::$APP->model, 'skills/intimidation', 'number') ?>
            <br>
            <?php Form::inputField(Application::$APP->model, 'skills/investigation', 'number') ?>
            <br>
            <?php Form::inputField(Application::$APP->model, 'skills/medicine', 'number') ?>
            <br>
            <?php Form::inputField(Application::$APP->model, 'skills/nature', 'number') ?>
            <br>
            <?php Form::inputField(Application::$APP->model, 'skills/perception', 'number') ?>
            <br>
            <?php Form::inputField(Application::$APP->model, 'skills/performance', 'number') ?>
            <br>
            <?php Form::inputField(Application::$APP->model, 'skills/persuasion', 'number') ?>
            <br>
            <?php Form::inputField(Application::$APP->model, 'skills/religion', 'number') ?>
            <br>
            <?php Form::inputField(Application::$APP->model, 'skills/sleightOfHand', 'number') ?>
            <br>
            <?php Form::inputField(Application::$APP->model, 'skills/stealth', 'number') ?>
            <br>
            <?php Form::inputField(Application::$APP->model, 'skills/survival', 'number') ?>
            <br>
        </div>
    </div>
</div>
<div class="submitContainer">
    <input class="submitAll" type="submit" form="createNew" value="CONTINUE">
</div>
<?php Form::end() ?>