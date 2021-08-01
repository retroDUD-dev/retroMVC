<?php

use app\core\form\Form;
use app\core\Application;

?>
<?php Form::begin('createNew', '', 'post') ?>
<div class="text header">Create a new character</div>
<div class="container" style="text-align: right;">
    <div class="col left">
        <?php Form::inputField($model, 'name', 'text', 'autofocus') ?>
        <br>
        <?php Form::inputField($model, 'class') ?>
        <br>
        <?php Form::inputField($model, 'background') ?>
        <br>
        <?php Form::inputField($model, 'race') ?>
        <br>
        <?php Form::inputField($model, 'numberOfDice', 'number') ?><?php Form::inputField($model, 'sidesOfDice', 'number') ?>
        <br>
        <div class="innerContainer">
            <div class="inner">
                <div class="text name inner">Attributes</div>
            </div>
            <?php Form::inputField($model, 'attributes/strength', 'number') ?>
            <br>
            <?php Form::inputField($model, 'attributes/dexterity', 'number') ?>
            <br>
            <?php Form::inputField($model, 'attributes/constitution', 'number') ?>
            <br>
            <?php Form::inputField($model, 'attributes/intelligence', 'number') ?>
            <br>
            <?php Form::inputField($model, 'attributes/wisdom', 'number') ?>
            <br>
            <?php Form::inputField($model, 'attributes/charisma', 'number') ?>
            <br>
        </div>
        <div class="innerContainer">
            <div class="inner">
                <div class="text name inner">Saving throws</div>
            </div>
            <?php Form::inputField($model, 'savingThrows/strength', 'number') ?>
            <br>
            <?php Form::inputField($model, 'savingThrows/dexterity', 'number') ?>
            <br>
            <?php Form::inputField($model, 'savingThrows/constitution', 'number') ?>
            <br>
            <?php Form::inputField($model, 'savingThrows/intelligence', 'number') ?>
            <br>
            <?php Form::inputField($model, 'savingThrows/wisdom', 'number') ?>
            <br>
            <?php Form::inputField($model, 'savingThrows/charisma', 'number') ?>
            <br>
        </div>
    </div>
    <div class="col center">
        <?php Form::inputField($model, 'alignment') ?>
        <br>
        <?php Form::inputField($model, 'proficiency', 'number') ?>
        <br>
        <?php Form::inputField($model, 'armor', 'number') ?>
        <br>
        <?php Form::inputField($model, 'initiative', 'number') ?>
        <br>
        <?php Form::inputField($model, 'speed', 'number') ?>
        <br>
        <?php Form::inputField($model, 'hitPoints', 'number') ?>
        <br>
        <?php Form::inputField($model, 'personalityTraits') ?>
        <br>
        <?php Form::inputField($model, 'ideals') ?>
        <br>
        <?php Form::inputField($model, 'bonds') ?>
        <br>
        <?php Form::inputField($model, 'flaws') ?>
        <br>
        <?php Form::textarea($model, 'proficiencies') ?>
        <br>
        <?php Form::textarea($model, 'languages') ?>
        <br>
        <?php Form::inputField($model, 'money/CP', 'number') ?>
        <br>
        <?php Form::inputField($model, 'money/SP', 'number') ?>
        <br>
        <?php Form::inputField($model, 'money/EP', 'number') ?>
        <br>
        <?php Form::inputField($model, 'money/GP', 'number') ?>
        <br>
        <?php Form::inputField($model, 'money/PP', 'number') ?>
        <br>
    </div>
    <div class="col right">
        <div class="innerContainer">
            <div class="inner">
                <div class="text name inner">Skills</div>
            </div>
            <?php Form::inputField($model, 'skills/acrobatics', 'number') ?>
            <br>
            <?php Form::inputField($model, 'skills/animalHandling', 'number') ?>
            <br>
            <?php Form::inputField($model, 'skills/arcana', 'number') ?>
            <br>
            <?php Form::inputField($model, 'skills/athletics', 'number') ?>
            <br>
            <?php Form::inputField($model, 'skills/deception', 'number') ?>
            <br>
            <?php Form::inputField($model, 'skills/history', 'number') ?>
            <br>
            <?php Form::inputField($model, 'skills/insight', 'number') ?>
            <br>
            <?php Form::inputField($model, 'skills/intimidation', 'number') ?>
            <br>
            <?php Form::inputField($model, 'skills/investigation', 'number') ?>
            <br>
            <?php Form::inputField($model, 'skills/medicine', 'number') ?>
            <br>
            <?php Form::inputField($model, 'skills/nature', 'number') ?>
            <br>
            <?php Form::inputField($model, 'skills/perception', 'number') ?>
            <br>
            <?php Form::inputField($model, 'skills/performance', 'number') ?>
            <br>
            <?php Form::inputField($model, 'skills/persuasion', 'number') ?>
            <br>
            <?php Form::inputField($model, 'skills/religion', 'number') ?>
            <br>
            <?php Form::inputField($model, 'skills/sleightOfHand', 'number') ?>
            <br>
            <?php Form::inputField($model, 'skills/stealth', 'number') ?>
            <br>
            <?php Form::inputField($model, 'skills/survival', 'number') ?>
            <br>
        </div>
    </div>
</div>
<div class="submitContainer">
    <input class="submitAll" type="submit" form="createNew" value="CONTINUE">
</div>
<?php Form::end() ?>