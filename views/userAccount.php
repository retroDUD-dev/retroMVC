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
            <?php Form::begin('characterManipulation', '', 'post') ?>
            <div class="row">
                <?php Form::button($model, 'createNew', 'Create New Character') ?>
                <br>
                <?php Form::button($model, 'characterSearch', 'View Characters') ?>
            </div>
            <?php Form::end() ?>
            <div class="row" style="border: 1px solid var(--border-color); width:33%;">
                <?php Form::begin('uploadLocal', '', 'post', 'enctype="multipart/form-data"') ?>
                <div class="text">Upload local character:</div>
                <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
                <?php Form::inputField($model, 'characterUpload', 'file', 'style="width: 80%" accept=".chr" required') ?>
                <div class="text inner">Allow other people to access my character?
                    <div style="height: 5px;"></div>
                    <div class="text">
                        Yes<?php Form::radio($model, 'isPublic', 'yes', 'checked') ?>
                    </div>
                    <br>
                    <div class="text">
                        No<?php Form::radio($model, 'isPublic', 'no',) ?>
                    </div>
                    <div style="height: 10px;"></div>
                    <?php Form::button($model, 'upload', 'Upload') ?>
                </div>
                <?php Form::end() ?>
            </div>
            <div class="row">
                <?php Form::begin('accountActions', '', 'post') ?>
                <?php Form::button($model, 'edit', 'Edit profile') ?>
                <br>
                <?php Form::button($model, 'logout', 'Sign out') ?>
                <?php Form::end() ?>
            </div>
        </div>
    </div>
</div>
<div class="submitContainer"></div>