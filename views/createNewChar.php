<?php

use app\core\form\Form;
use app\core\Application;

?>
<?= Form::begin('createNew', '', 'post') ?>
<div class="text header">Create a new character</div>
<div class="container" style="text-align: right;">
    <div class="col left">
        <?= Form::inputField($model, 'name', '', 'autofocus') ?>
        <br>
        <?= Form::inputField($model, 'class') ?>
        <br>
        <?= Form::inputField($model, 'background') ?>
        <br>
        <?= Form::inputField($model, 'race') ?>
        <br>
        <?= Form::inputField($model, 'numberOfDice')->numberField() ?><?= Form::inputField($model, 'sidesOfDice')->numberField() ?>
        <br>
        <div class="innerContainer">
            <div class="inner">
                <div class="text name inner">Attributes</div>
            </div>
            <?= Form::inputField($model, 'attributes/strength')->numberField() ?>
            <br>
            <?= Form::inputField($model, 'attributes/dexterity')->numberField() ?>
            <br>
            <?= Form::inputField($model, 'attributes/constitution')->numberField() ?>
            <br>
            <?= Form::inputField($model, 'attributes/intelligence')->numberField() ?>
            <br>
            <?= Form::inputField($model, 'attributes/wisdom')->numberField() ?>
            <br>
            <?= Form::inputField($model, 'attributes/charisma')->numberField() ?>
            <br>
        </div>
        <div class="innerContainer">
            <div class="inner">
                <div class="text name inner">Saving throws</div>
            </div>
            <?= Form::inputField($model, 'savingThrows/strength')->numberField() ?>
            <br>
            <?= Form::inputField($model, 'savingThrows/dexterity')->numberField() ?>
            <br>
            <?= Form::inputField($model, 'savingThrows/constitution')->numberField() ?>
            <br>
            <?= Form::inputField($model, 'savingThrows/intelligence')->numberField() ?>
            <br>
            <?= Form::inputField($model, 'savingThrows/wisdom')->numberField() ?>
            <br>
            <?= Form::inputField($model, 'savingThrows/charisma')->numberField() ?>
            <br>
        </div>
    </div>
    <div class="col center">
        <?= Form::inputField($model, 'alignment') ?>
        <br>
        <?= Form::inputField($model, 'proficiency')->numberField() ?>
        <br>
        <?= Form::inputField($model, 'armor')->numberField() ?>
        <br>
        <?= Form::inputField($model, 'initiative')->numberField() ?>
        <br>
        <?= Form::inputField($model, 'speed')->numberField() ?>
        <br>
        <?= Form::inputField($model, 'hitPoints')->numberField() ?>
        <br>
        <?= Form::inputField($model, 'personalityTraits') ?>
        <br>
        <?= Form::inputField($model, 'ideals') ?>
        <br>
        <?= Form::inputField($model, 'bonds') ?>
        <br>
        <?= Form::inputField($model, 'flaws') ?>
        <br>
        <?= Form::textarea($model, 'proficiencies') ?>
        <br>
        <?= Form::textarea($model, 'languages') ?>
        <br>
        <?= Form::inputField($model, 'money/CP')->numberField() ?>
        <br>
        <?= Form::inputField($model, 'money/SP')->numberField() ?>
        <br>
        <?= Form::inputField($model, 'money/EP')->numberField() ?>
        <br>
        <?= Form::inputField($model, 'money/GP')->numberField() ?>
        <br>
        <?= Form::inputField($model, 'money/PP')->numberField() ?>
        <br>
    </div>
    <div class="col right">
        <div class="innerContainer">
            <div class="inner">
                <div class="text name inner">Skills</div>
            </div>
            <?= Form::inputField($model, 'skills/acrobatics')->numberField() ?>
            <br>
            <?= Form::inputField($model, 'skills/animalHandling')->numberField() ?>
            <br>
            <?= Form::inputField($model, 'skills/arcana')->numberField() ?>
            <br>
            <?= Form::inputField($model, 'skills/athletics')->numberField() ?>
            <br>
            <?= Form::inputField($model, 'skills/deception')->numberField() ?>
            <br>
            <?= Form::inputField($model, 'skills/history')->numberField() ?>
            <br>
            <?= Form::inputField($model, 'skills/insight')->numberField() ?>
            <br>
            <?= Form::inputField($model, 'skills/intimidation')->numberField() ?>
            <br>
            <?= Form::inputField($model, 'skills/investigation')->numberField() ?>
            <br>
            <?= Form::inputField($model, 'skills/medicine')->numberField() ?>
            <br>
            <?= Form::inputField($model, 'skills/nature')->numberField() ?>
            <br>
            <?= Form::inputField($model, 'skills/perception')->numberField() ?>
            <br>
            <?= Form::inputField($model, 'skills/performance')->numberField() ?>
            <br>
            <?= Form::inputField($model, 'skills/persuasion')->numberField() ?>
            <br>
            <?= Form::inputField($model, 'skills/religion')->numberField() ?>
            <br>
            <?= Form::inputField($model, 'skills/sleightOfHand')->numberField() ?>
            <br>
            <?= Form::inputField($model, 'skills/stealth')->numberField() ?>
            <br>
            <?= Form::inputField($model, 'skills/survival')->numberField() ?>
            <br>
        </div>
    </div>
</div>
<div class="submitContainer">
    <input class="submitAll" type="submit" form="createNew" value="CONTINUE">
</div>
<?= Form::end() ?>