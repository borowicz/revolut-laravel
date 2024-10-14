<?php

namespace App\Livewire\Forms;

use Livewire\Component;
use Livewire\WithFileUploads;

class UploadForm extends Component
{
    use WithFileUploads;

    public $file;
    public $isUploaded = false;

    protected $rules = [
            'file' => 'required|mimes:csv,txt|max:10240', // Maximum file size of 1MB
        ];

    public function resetUpload()
    {
        $this->isUploaded = false;
        $this->file = '';

        session()->forget('message');
        session()->forget('importStats');
    }
}
