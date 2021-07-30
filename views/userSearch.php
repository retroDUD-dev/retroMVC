<?php

use app\core\Application;
use app\core\form\Form;

use function Composer\Autoload\includeFile;

?>
<?php Form::begin('usersearch', '', 'post') ?>
<div class="innerContainer text">
    <div style="text-align: center; text-transform: uppercase;">search by:</div>
    <div class="buttonContainer" style="padding-top: 20px;">
        <?php Form::inputField($model, 'searchById', 'number', 'autofocus') ?>
        <?php Form::inputField($model, 'searchByFirstname') ?>
        <?php Form::inputField($model, 'searchByLastname') ?>
        <?php Form::inputField($model, 'searchByEmail', 'email') ?>
        <?php Form::select($model, 'searchByStatus', ['0' => 'Active', '1' => 'Inactive', '2' => 'Deleted']) ?>
        <?php Form::button($model, 'search', 'Search') ?>
    </div>
</div>
<?php Form::end() ?>

<?php if (Application::$APP->session->get('searchResults')) : ?>
    <?php includeFile(Application::$ROOT_DIR . "/runtime/AdminSearchBy" . Application::$APP->session->get('user')['primaryValue'] . ".php") ?>
<?php endif ?>