<?php

namespace app\models;

use \PDO;
use app\core\Application;
use app\core\db\DbModel;

class CharacterSearch extends DbModel
{
    public function __construct()
    {
    }

    public string $searchByName;
    public string $searchByClass;
    public string $searchByLevel;
    public string $searchByUser;
    public string $searchOnlyMine;
    public string $file = '';
    public string $user = '';
    public string $isPublic = '';

    public static function tableName(): string
    {
        return 'Characters';
    }

    public function primaryKey(): string
    {
        return 'id';
    }

    public function attributes(): array
    {
        return [
            'searchByName',
            'searchByClass',
            'searchByLevel',
            'searchByUser',
            'searchOnlyMine',
            'file'
        ];
    }

    public function rules(): array
    {
        return [];
    }

    public function getLabel($attribute): string
    {
        if (str_contains($attribute, 'downloadPdf')) {
            $attribute = 'downloadPdf';
        }
        if (str_contains($attribute, 'delete')) {
            $attribute = 'delete';
        }

        return $this->labels()[$attribute] ?? $attribute;
    }

    public function labels(): array
    {
        return [
            'searchByName' => 'Character name: ',
            'searchByClass' => 'Class: ',
            'searchByLevel' => 'Level: ',
            'searchByUser' => 'Created by: ',
            'searchOnlyMine' => 'Only show my Characters: ',
            'search' => '',
            'downloadPdf' => '',
            'delete' => ''
        ];
    }

    public function search(array $by): bool
    {
        $html = '';
        $bySelf = $by;
        $bySelf['user'] = Application::$APP->session->get('user')['primaryValue'];
        $r = $this->findAll($bySelf);

        if (!isset($where['searchOnlyMine'])) {
            $byOthers = $by;
            $r = array_merge($r, $this->findAll($byOthers));
        }

        foreach ($r as $character) {
            if ($character->user === "" . $bySelf['user'] . "") {
                $html .= "<tr class='header text'><td class='tCell'>" . $character->name . "</td><td class='tCell'>" . " level " . $character->level . "</td><td class='tCell'>" . $character->race . "</td><td class='tCell'>" . $character->class . "</td>";
                $html .= "<td class='tCell'>created by <b>you.</b></td><td class='tCell'><?php app\core\\form\Form::button(app\core\Application::\$APP->session->get('characterSearch'), 'downloadPdf" . $character->id . "', 'Download PDF') ?><?php app\core\\form\Form::button(app\core\Application::\$APP->session->get('characterSearch'), 'delete" . $character->id . "', 'delete') ?></td></tr>";
            } elseif ($character->isPublic) {
                $html .= "<tr class='header text'><td class='tCell'>" . $character->name . "</td><td class='tCell'>" . " level " . $character->level . "</td><td class='tCell'>" . $character->race . "</td><td class='tCell'>" . $character->class . "</td>";
                if (Application::isAdmin()) {
                    $html .= "<td class='tCell'>created publicly by user ID: <b>$character->user</b></td><td class='tCell'><?php app\core\\form\Form::button(app\core\Application::\$APP->session->get('characterSearch'), 'downloadPdf" . $character->id . "', 'Download PDF') ?><?php app\core\\form\Form::button(app\core\Application::\$APP->session->get('characterSearch'), 'delete" . $character->id . "', 'delete') ?></td></tr></td></tr>";
                } else {
                    $html .= "<td class='tCell'>created publicly</td><td class='tCell'><?php app\core\\form\Form::button(app\core\Application::\$APP->session->get('characterSearch'), 'downloadPdf" . $character->id . "', 'Download PDF') ?></td></tr>";
                }
            } elseif (Application::isAdmin()) {
                $html .= "<tr class='header text'><td class='tCell'>" . $character->name . "</td><td class='tCell'>" . " level " . $character->level . "</td><td class='tCell'>" . $character->race . "</td><td class='tCell'>" . $character->class . "</td>";
                $html .= "<td class='tCell'>created privately by user ID: <b>$character->user</b></td><td class='tCell'><?php app\core\\form\Form::button(app\core\Application::\$APP->session->get('characterSearch'), 'downloadPdf" . $character->id . "', 'Download PDF') ?><?php app\core\\form\Form::button(app\core\Application::\$APP->session->get('characterSearch'), 'delete" . $character->id . "', 'delete') ?></td></tr>";
            }
        }
        if (!$html) {
            $html = '<div class="text error">No results.</div>';
        }

        $handle = fopen(Application::$ROOT_DIR . "/runtime/SearchBy" . Application::$APP->session->get('user')['primaryValue'] . ".php", "w");
        fwrite($handle, $html, strlen($html));
        fclose($handle);
        return file_exists(Application::$ROOT_DIR . "/runtime/SearchBy" . Application::$APP->session->get('user')['primaryValue'] . ".php");
    }
}
