<?php

namespace app\models;

use app\core\Application;
use app\core\UserModel;
use PDO;

class UserSearch extends UserModel
{
    public function __construct()
    {
    }

    public string $searchById = '';
    public string $searchByFirstname = '';
    public string $searchByLastname = '';
    public string $searchByEmail = '';
    public string $searchByStatus = '';
    public string $userSearch = '';

    public static function tableName(): string
    {
        return 'users';
    }

    public function primaryKey(): string
    {
        return 'id';
    }

    public function attributes(): array
    {
        return [
            'searchById',
            'searchByFirstname',
            'searchByLastname',
            'searchByEmail',
            'searchByStatus'
        ];
    }

    public function labels(): array
    {
        return [
            'searchById' => 'ID: ',
            'searchByFirstname' => 'Name: ',
            'searchByLastname' => 'Lastname: ',
            'searchByEmail' => 'Email: ',
            'searchByStatus' => 'Status: ',
            'edit' => '',
            'delete' => '',
            'userSearch' => ''
        ];
    }

    public function rules(): array
    {
        return [];
    }

    public function getLabel($attribute): string
    {
        if (str_contains($attribute, 'edit')) {
            $attribute = 'edit';
        }
        if (str_contains($attribute, 'delete')) {
            $attribute = 'delete';
        }

        return $this->labels()[$attribute] ?? $attribute;
    }

    public function getDisplayName(): string
    {
        return $this->firstname;
    }

    public function search(array $by): bool
    {
        $html = '';
        $r = $this->findAll($by);

        foreach ($r as $user) {
            $html .= "<tr class='header text'><td class='tCell'>" . $user->statusToString() . "</td><td class='tCell'>" . $user->typeToString() . "</td><td class='tCell'>" . $user->firstname. " ". $user->lastname . "</td><td class='tCell'>" . " &#60;" . $user->email . "&#62;</td><td class='tCell'><?php app\core\\form\Form::button(app\core\Application::\$APP->session->get('userSearch'), 'edit" . $user->id . "', 'EDIT') ?> <?php app\core\\form\Form::button(app\core\Application::\$APP->session->get('userSearch'), 'delete" . $user->id . "', 'DELETE') ?></td></tr>";
        }
        if (!$html) {
            $html = '<div class="text error">No results.</div>';
        }

        

        $handle = fopen(Application::$ROOT_DIR . "/runtime/AdminSearchBy" . Application::$APP->session->get('user')['primaryValue'] . ".php", "w");
        fwrite($handle, $html, strlen($html));
        fclose($handle);
        return file_exists(Application::$ROOT_DIR . "/runtime/AdminSearchBy" . Application::$APP->session->get('user')['primaryValue'] . ".php");
    }
}
