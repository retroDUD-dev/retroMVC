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
            'delete' => ''
        ];
    }

    public function rules(): array
    {
        return [];
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
            $html .= "<div class='text innerContainer' style='height: 50px; vertical-align: middle; padding-top:25px; padding-left: 10px; padding-right: 10px; margin: 0px;'>" . $user->status . " " . $user->type . " user:  " . $user->firstname . " " . $user->lastname . " &#60;" . $user->email . "&#62; <?php app\core\\form\Form::button(app\core\Application::\$APP->session->get('userSearch'), 'edit" . $user->id . "', 'EDIT') ?> <?php app\core\\form\Form::button(app\core\Application::\$APP->session->get('userSearch'), 'delete" . $user->id . "', 'DELETE') ?></div>";
        }
        if (!$html) {
            $html = '<div class="text">No results.</div>';
        }

        $handle = fopen(Application::$ROOT_DIR . "/runtime/AdminSearchBy" . Application::$APP->session->get('user')['primaryValue'] . ".php", "w");
        fwrite($handle, $html, strlen($html));
        fclose($handle);
        return file_exists(Application::$ROOT_DIR . "/runtime/AdminSearchBy" . Application::$APP->session->get('user')['primaryValue'] . ".php");
    }
}
