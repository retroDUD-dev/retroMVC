<?php

use app\core\Application;
use app\core\form\Form;
use app\models\User;

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

        <?php

        $owner = new User();
        $requester = Application::$APP->session->get('user')['primaryValue'];

        foreach ($data as $character) {
            $owner = $owner->findOne(['id' => $character->user]);
            if ($character->user === "" . $requester . "") {
                echo "
                        <tr class='text'>
                            <td class='tCell'>" .
                    $character->name . "
                            </td>
                            <td class='tCell'>" . "
                                level " . $character->level . "
                            </td>
                            <td class='tCell'>" .
                    $character->race . "
                            </td>
                            <td class='tCell'>" .
                    $character->class . "
                            </td>
                            <td class='tCell'>
                                created by <span style='font-size: 26px; color: var(--message-color); font-weight: bold;'>you.</span>
                            </td>
                            <td class='tCell'>" .
                    Form::button($character, "characterPreview ". $character->id, 'Preview') .
                    Form::button($character, "delete" . $character->id, 'delete') . "
                            </td>
                        </tr>
                        ";
            } elseif ($character->isPublic) {
                echo "
                    <tr class='text'>
                        <td class='tCell'>" .
                    $character->name . "
                        </td>
                        <td class='tCell'>" . "
                            level " . $character->level . "
                        </td>
                        <td class='tCell'>" .
                    $character->race . "
                        </td>
                        <td class='tCell'>" .
                    $character->class . "
                        </td>";
                if (Application::isAdmin()) {
                    echo "
                            <td class='tCell'>
                                created publicly by user <b>" . $owner->displayName . "</b>(ID: " . $requester . "
                            </td>
                            <td class='tCell'>" .
                        Form::button($character, "characterPreview ". $character->id, 'Preview') .
                        Form::button($character, "delete" . $character->id, 'delete') . "
                            </td>
                        </tr>
                        ";
                } else {
                    echo "
                            <td class='tCell'>
                                created publicly by user <b>" . $owner->displayName . "</b>
                            </td>
                            <td class='tCell'>" .
                        Form::button($character, "characterPreview ". $character->id, 'Preview') . "
                            </td>
                        </tr>
                        ";
                }
            } elseif (Application::isAdmin()) {
                echo "
                    <tr class='text'>
                        <td class='tCell'>" .
                    $character->name . "
                        </td>
                        <td class='tCell'>" . "
                            level " . $character->level . "
                        </td>
                        <td class='tCell'>" .
                    $character->race . "
                        </td>
                        <td class='tCell'>" .
                    $character->class . "
                        </td>
                        <td class='tCell'>
                            created <span style='font-size: 26px; color: var(--error-color)'>privately</span> by user <b>$owner->displayName</b>(ID: " . $requester . "
                        </td>
                        <td class='tCell'>" .
                    Form::button($character, "characterPreview ". $character->id, 'Preview') .
                    Form::button($character, "delete" . $character->id, 'delete') . "
                        </td>
                    </tr>
                    ";
            }
        }
        if (!$html) {
            $html = '<div class="text error">No results.</div>';
        }
        ?>
    </tbody>
</table>