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
        $r = $this->findAll($by);
        foreach ($r as $character) {
            if ($character->user === Application::$APP->session->get('user')['primaryValue']) {
                $html .= "<div class='text innerContainer' style='height: 50px; vertical-align: middle; padding-top:25px; padding-left: 10px; padding-right: 10px; margin: 0px;'>" . $character->name . ", " . " level " . $character->level . " " . $character->race . " " . $character->class . "; created by <b>you.</b><?php app\core\\form\Form::button(app\core\Application::\$APP->session->get('characterSearch'), 'downloadPdf" . $character->id . "', 'Download PDF') ?><?php app\core\\form\Form::button(app\core\Application::\$APP->session->get('characterSearch'), 'delete" . $character->id . "', 'delete') ?></div><br>";
            } elseif ($character->isPublic) {
                $html .= "<div class='text innerContainer' style='height: 50px; vertical-align: middle; padding-top:25px; padding-left: 10px; padding-right: 10px; margin: 0px;'>" . $character->name . ", " . " level " . $character->level . " " . $character->race . " " . $character->class . "; created publicly.<?php app\core\\form\Form::button(app\core\Application::\$APP->session->get('characterSearch'), 'downloadPdf" . $character->id . "', 'Download PDF') ?></div><br>";
            }
        }
        if (!$html) {
            $html = '<div class="text">No results.</div>';
        }

        $handle = fopen(Application::$ROOT_DIR . "/runtime/SearchBy" . Application::$APP->session->get('user')['primaryValue'] . ".php", "w");
        fwrite($handle, $html, strlen($html));
        fclose($handle);
        return file_exists(Application::$ROOT_DIR . "/runtime/SearchBy" . Application::$APP->session->get('user')['primaryValue'] . ".php");
    }

    public function findAll(array $where): array|false
    {
        $tableName = static::tableName();
        $OnlyMine = false;
        if (isset($where['searchOnlyMine'])) {
            unset($where['searchOnlyMine']);
            $OnlyMine = true;
        }
        if (empty($where)) {
            $sql = '';
        } else {
            $attributes = array_keys($where);
            $sql = implode(" AND ", array_map(fn ($attr) => "$attr = :$attr", $attributes));
            $sql = " AND " . $sql;
        }
        if ($OnlyMine) {
            $statement = self::prepare("SELECT * FROM $tableName WHERE user = " . Application::$APP->session->get('user')['primaryValue'] . " $sql");
        } else {
            $statement = self::prepare("SELECT * FROM $tableName WHERE (isPublic = 1 OR user = " . Application::$APP->session->get('user')['primaryValue'] . ") $sql");
        }
        foreach ($where as $key => $value) {
            $statement->bindValue(":$key", $value);
        }
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_CLASS, static::class);
    }
}
