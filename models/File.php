<?php

namespace app\models;

use app\core\Model;

class File extends Model
{
    public string $upload = '';
    public string $isPublic = '';
    public string $saveFile = '';
    public string $downloadPdf = '';
    public string $newCharacter = '';

    public function attributes(): array
    {
        return [
            'upload',
            'isPublic',
            'saveFile',
            'downloadPdf',
            'newCharacter'
        ];
    }



    public function labels(): array
    {
        return [
            'upload' => '',
            'isPublic' => '',
            'saveFile' => '',
            'downloadPdf' => '',
            'newCharacter' => ''
        ];
    }

    public function rules(): array
    {
        return array();
    }

    public function isPublic(): bool
    {
        $strSwitch = strtolower($this->isPublic);
        switch ($strSwitch) {
            case 'yes':
                return true;
            default:
                return false;
        }
    }

    public function reset(): void
    {
        $this->upload = '';
        $this->isPublic = '';
        $this->saveFile = '';
        $this->downloadPdf = '';
    }
}
