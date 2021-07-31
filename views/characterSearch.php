<?php

use app\core\Application;
use app\core\form\Form;

use function Composer\Autoload\includeFile;

?>
<?php Form::begin('charactersearch', '', 'post') ?>
<div class="innerContainer text">
    <div style="text-align: center; text-transform: uppercase;">search by:</div>
    <div class="buttonContainer" style="padding-top: 20px;">
        <?php Form::inputField($model, 'searchByName', 'text', 'autofocus') ?>
        <?php Form::inputField($model, 'searchByClass') ?>
        <?php Form::inputField($model, 'searchByLevel', 'number') ?>
        <?php Form::checkbox($model, 'searchOnlyMine', 'on') ?>
        <?php Form::button($model, 'search', 'Search') ?>
    </div>
</div>
<?php Form::end() ?>

<?php if (Application::$APP->session->get('searchResults')) : ?>
    <table>
        <tbody>
            <tr class="tHead header text">
                <th class="tHead tCell">
                    Name
                </th>
                <th class="tHead tCell">
                    Level
                </th>
                <th class="tHead tCell">
                    Race
                </th>
                <th class="tHead tCell">
                    Class
                </th>
                <th class="tHead tCell">
                    Ownership
                </th>
                <th class="tHead tCell">
                    Options
                </th>
            </tr>
            <?php includeFile(Application::$ROOT_DIR . "/runtime/SearchBy" . Application::$APP->session->get('user')['primaryValue'] . ".php") ?>
        </tbody>
    </table>
<?php endif ?>