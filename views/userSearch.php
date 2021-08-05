<?php

use app\core\Application;
use app\core\form\Form;

use function Composer\Autoload\includeFile;

?>
<?= Form::begin('usersearch', '', 'post') ?>
<div class="innerContainer text">
    <div style="text-align: center; text-transform: uppercase;">search by:</div>
    <div class="buttonContainer" style="padding-top: 20px;">
        <?= Form::inputField($model, 'searchById', '', 'autofocus')->numberField() ?>
        <?= Form::inputField($model, 'searchByDisplayName') ?>
        <?= Form::inputField($model, 'searchByFirstname') ?>
        <?= Form::inputField($model, 'searchByLastname') ?>
        <?= Form::inputField($model, 'searchByEmail')->emailField() ?>
        <?= Form::select($model, 'searchByStatus', ['0' => 'Active', '1' => 'Inactive', '2' => 'Deactivated']) ?>
        <?= Form::button($model, 'search', 'Search') ?>
    </div>
</div>
<?= Form::end() ?>

<table>
    <tbody>
        <tr class="tHead header text">
            <th class="tHead tCell">
                Status
            </th>
            <th class="tHead tCell">
                type
            </th>
            <th class="tHead tCell">
                Display Name
            </th>
            <th class="tHead tCell">
                Name
            </th>
            <th class="tHead tCell">
                email
            </th>
            <th class="tHead tCell">
                Options
            </th>
        </tr>
        <?php

        foreach ($data as $user) {
            echo "
                <tr class='text'>
                    <td class='tCell'>" .
                $user->statusToString() . "
                    </td>
                    <td class='tCell'>" .
                $user->typeToString() . "
                </td>
                <td class='tCell'>" .
                $user->displayName . "
                </td>
                <td class='tCell'>" .
                $user->firstname . " " . $user->lastname . "
                </td>
                <td class='tCell'>" . "
                    &#60;" . $user->email . "&#62;
                </td>
                <td class='tCell'>" .
                Form::button($user, "edit" . $user->id, 'EDIT') .
                Form::button($user, "delete" . $user->id, 'DELETE') . "
                </td>
            </tr>
            ";
        }

        ?>
    </tbody>
</table>