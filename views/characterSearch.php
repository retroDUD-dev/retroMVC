<?php

use app\core\Application;
use app\core\form\Form;

use function Composer\Autoload\includeFile;

?>
<?= Form::begin('charactersearch', '', 'post') ?>
<div class="innerContainer text">
    <div style="text-align: center; text-transform: uppercase;">search by:</div>
    <div class="buttonContainer" style="padding-top: 20px;">
        <?= Form::inputField($model, 'searchByName', '', 'autofocus') ?>
        <?= Form::inputField($model, 'searchByClass') ?>
        <?= Form::inputField($model, 'searchByLevel')->numberField ?>
        <?= Form::inputField($model, 'searchOnlyMine', 'on')->checkField() ?>
        <?= Form::button($model, 'search', 'Search') ?>
    </div>
</div>
<?= Form::end() ?>

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