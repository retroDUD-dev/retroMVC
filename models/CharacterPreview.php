<?php

namespace app\models;

class CharacterPreview extends File
{
    public function __construct()
    {
    }

    public string $messageOwner = '';

    public function attributes(): array
    {
        return [
            'messageOwner',
            'downloadPdf',
            'saveFile'
        ];
    }

    public function rules(): array
    {
        return [];
    }

    public function labels(): array
    {
        return [
            'messageOwner' => '',
            'downloadPdf' => '',
            'saveFile' => '',
        ];
    }
}
