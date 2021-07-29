<?php

namespace app\models;

use app\core\Model;

class File extends Model
{
    public string $upload = '';
    public string $isPublic = '';
    public string $saveFile = '';
    public string $downloadPdf = '';

    public function attributes(): array
    {
        return [
            'upload',
            'isPublic',
            'saveFile',
            'downloadPdf'
        ];
    }

    public function rules(): array
    {
        return array();
    }

    public function isPublic(): bool
    {
        $this->isPublic = strtolower($this->isPublic);
        switch ($this->isPublic) {
            case 'yes':
                return true;
            default:
                return false;
        }
    }

    public function type(): string|false
    {
        if ($this->upload) {
            return 'upload';
        } elseif ($this->saveFile) {
            return 'saveFile';
        } elseif ($this->downloadPdf) {
            return 'downloadPdf';
        } else {
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
