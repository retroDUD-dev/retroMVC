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
        if (str_contains($attribute, 'characterPreview')) {
            $attribute = 'characterPreview';
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
            'characterPreview' => '',
            'delete' => ''
        ];
    }

    public function search(array $by): bool
    {
        $html = '';
        $owner = new User();
        $requester = Application::$APP->session->get('user')['primaryValue'];
        
        if (isset($by['searchOnlyMine'])) {
            unset($by['searchOnlyMine']);
            $r = $this->findAll($by);
        } else {
            $r = $this->findAll($by);
        }

        foreach ($r as $character) {
            $owner = $owner->findOne(['id' => $character->user]);
            if ($character->user === "" . $requester . "") {
                $html .= "<tr class='text'><td class='tCell'>" . $character->name . "</td><td class='tCell'>" . " level " . $character->level . "</td><td class='tCell'>" . $character->race . "</td><td class='tCell'>" . $character->class . "</td>";
                $html .= "<td class='tCell'>created by <span style='font-size: 26px; color: var(--message-color); font-weight: bold;'>you.</span></td><td class='tCell'><?= app\core\\form\Form::button(app\core\Application::\$APP->session->get('characterSearch'), 'characterPreview" . $character->id . "', 'Preview') ?><?= app\core\\form\Form::button(app\core\Application::\$APP->session->get('characterSearch'), 'delete" . $character->id . "', 'delete') ?></td></tr>";
            } elseif ($character->isPublic) {
                $html .= "<tr class='text'><td class='tCell'>" . $character->name . "</td><td class='tCell'>" . " level " . $character->level . "</td><td class='tCell'>" . $character->race . "</td><td class='tCell'>" . $character->class . "</td>";
                if (Application::isAdmin()) {
                    $html .= "<td class='tCell'>created publicly by user <b>".$owner->displayName."</b>(ID: ".$requester."</td><td class='tCell'><?= app\core\\form\Form::button(app\core\Application::\$APP->session->get('characterSearch'), 'characterPreview" . $character->id . "', 'Preview') ?><?= app\core\\form\Form::button(app\core\Application::\$APP->session->get('characterSearch'), 'delete" . $character->id . "', 'delete') ?></td></tr></td></tr>";
                } else {
                    $html .= "<td class='tCell'>created publicly by user <b>".$owner->displayName."</b></td><td class='tCell'><?= app\core\\form\Form::button(app\core\Application::\$APP->session->get('characterSearch'), 'characterPreview" . $character->id . "', 'Preview') ?></td></tr>";
                }
            } elseif (Application::isAdmin()) {
                $html .= "<tr class='text'><td class='tCell'>" . $character->name . "</td><td class='tCell'>" . " level " . $character->level . "</td><td class='tCell'>" . $character->race . "</td><td class='tCell'>" . $character->class . "</td>";
                $html .= "<td class='tCell'>created <span style='font-size: 26px; color: var(--error-color)'>privately</span> by user <b>$owner->displayName</b>(ID: ".$requester."</td><td class='tCell'><?= app\core\\form\Form::button(app\core\Application::\$APP->session->get('characterSearch'), 'characterPreview" . $character->id . "', 'Preview') ?><?= app\core\\form\Form::button(app\core\Application::\$APP->session->get('characterSearch'), 'delete" . $character->id . "', 'delete') ?></td></tr>";
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
