<?php

use app\core\Application;
use app\core\form\Form;

$this->title = 'My Account';

?>
<div class="header text">Hello there, <?= Application::$APP->session->get('user')['displayName']; ?>!</div>
<div class="containerCol">
    <div class="row text">
        How would you like to proceed?
    </div>
    <div class="innerContainer">
        <div class="container">
            <?= Form::begin('characterManipulation', '', 'post') ?>
            <div class="row">
                <?= Form::button($model, 'createNew', 'Create New Character') ?>
                <br>
                <?= Form::button($model, 'characterSearch', 'View Characters') ?>
            </div>
            <?= Form::end() ?>
            <div class="row" style="border: 1px solid var(--border-color); width:33%;">
                <?= Form::begin('uploadLocal', '', 'post', 'enctype="multipart/form-data"') ?>
                <div class="text">Upload local character:</div>
                <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
                <?= Form::inputField($model, 'characterUpload', '', 'style="width: 80%" accept=".chr" required')->fileField() ?>
                <div class="text inner">Allow other people to access my character?
                    <div style="height: 5px;"></div>
                    <div class="text">
                        Yes<?= Form::inputField($model, 'isPublic', 'yes', 'checked')->radioField() ?>
                    </div>
                    <br>
                    <div class="text">
                        No<?= Form::inputField($model, 'isPublic', 'no',)->radioField() ?>
                    </div>
                    <div style="height: 10px;"></div>
                    <?= Form::button($model, 'upload', 'Upload') ?>
                </div>
                <?= Form::end() ?>
            </div>
            <div class="row">
                <?= Form::begin('accountActions', '', 'post') ?>
                <?= Form::button($model, 'edit', 'Edit profile') ?>
                <br>
                <?= Form::button($model, 'logout', 'Sign out') ?>
                <?= Form::end() ?>
            </div>
        </div>
    </div>
</div>
<div class="submitContainer"></div>