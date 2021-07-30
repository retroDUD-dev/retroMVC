<?php

namespace app\models;

use app\core\Model;

class AccountActions extends Model
{
    public function __construct(
        public string $displayName = ''
    ) {
    }

    public string $createNew;
    public string $characterSearch;
    public string $characterUpload;
    public string $isPublic;
    public string $upload;
    public string $edit;
    public string $logout;

    public function attributes(): array
    {
        return [
            'createNew',
            'characterSearch',
            'characterUpload',
            'isPublic',
            'upload',
            'edit',
            'logout'
        ];
    }

    public function rules(): array
    {
        return [];
    }

    public function labels(): array
    {
        return [
            'createNew' => '',
            'characterSearch' => '',
            'characterUpload' => '',
            'isPublic' => '',
            'upload' => '',
            'edit' => '',
            'logout' => ''
        ];
    }

    public function getDisplayName(): string
    {
        return $this->displayName;
    }
}
